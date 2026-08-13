<?php

namespace App\Services;

/**
 * Générateur de sitemap.
 *
 * Remplace roumen/sitemap (abandonné, incompatible Laravel 11) en ne
 * réimplémentant que la surface réellement utilisée par SitemapController :
 * add(), addSitemap(), render(), store() et model->resetItems().
 */
class Sitemap
{
    /** @var array<int, array<string, mixed>> */
    public array $items = [];

    /** @var array<int, array<string, mixed>> */
    public array $sitemaps = [];

    /**
     * Conservé pour la compatibilité avec l'appel `$sitemap->model->resetItems()`.
     */
    public Sitemap $model;

    public function __construct()
    {
        $this->model = $this;
    }

    /**
     * Ajoute une URL au sitemap.
     *
     * @param  array<int, array<string, mixed>>|null  $images
     */
    public function add(
        string $loc,
        string|int|null $lastmod = null,
        string|float|null $priority = null,
        ?string $freq = null,
        ?array $images = null,
        ?string $title = null,
    ): void {
        $this->items[] = compact('loc', 'lastmod', 'priority', 'freq', 'images', 'title');
    }

    /**
     * Ajoute un sitemap enfant à l'index.
     */
    public function addSitemap(string $loc, string|int|null $lastmod = null): void
    {
        $this->sitemaps[] = compact('loc', 'lastmod');
    }

    public function resetItems(array $items = []): void
    {
        $this->items = $items;
    }

    public function resetSitemaps(array $sitemaps = []): void
    {
        $this->sitemaps = $sitemaps;
    }

    /**
     * Rend le sitemap au format demandé ("xml" ou "sitemapindex").
     */
    public function render(string $format = 'xml'): string
    {
        return $format === 'sitemapindex'
            ? $this->renderSitemapIndex()
            : $this->renderUrlSet();
    }

    /**
     * Écrit le sitemap sur disque et vide les éléments accumulés.
     */
    public function store(string $format, string $filename, ?string $path = null): string
    {
        $path = $path ?: public_path();

        if (! is_dir($path)) {
            mkdir($path, 0o755, true);
        }

        $file = rtrim($path, '/\\').DIRECTORY_SEPARATOR.$filename.'.xml';

        file_put_contents($file, $this->render($format));

        if ($format === 'sitemapindex') {
            $this->resetSitemaps();
        } else {
            $this->resetItems();
        }

        return $file;
    }

    protected function renderUrlSet(): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n"
            .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"'
            .' xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">'."\n";

        foreach ($this->items as $item) {
            $xml .= "\t<url>\n";
            $xml .= "\t\t<loc>".self::escape($item['loc'])."</loc>\n";

            if (! empty($item['lastmod'])) {
                $xml .= "\t\t<lastmod>".self::formatDate($item['lastmod'])."</lastmod>\n";
            }

            if (! empty($item['freq'])) {
                $xml .= "\t\t<changefreq>".self::escape($item['freq'])."</changefreq>\n";
            }

            if (! empty($item['priority']) || $item['priority'] === 0 || $item['priority'] === '0') {
                $xml .= "\t\t<priority>".self::escape((string) $item['priority'])."</priority>\n";
            }

            foreach ($item['images'] ?? [] as $image) {
                $xml .= "\t\t<image:image>\n";
                $xml .= "\t\t\t<image:loc>".self::escape($image['url'] ?? '')."</image:loc>\n";

                if (! empty($image['title'])) {
                    $xml .= "\t\t\t<image:title>".self::escape($image['title'])."</image:title>\n";
                }

                if (! empty($image['caption'])) {
                    $xml .= "\t\t\t<image:caption>".self::escape($image['caption'])."</image:caption>\n";
                }

                $xml .= "\t\t</image:image>\n";
            }

            $xml .= "\t</url>\n";
        }

        return $xml.'</urlset>';
    }

    protected function renderSitemapIndex(): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n"
            .'<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($this->sitemaps as $sitemap) {
            $xml .= "\t<sitemap>\n";
            $xml .= "\t\t<loc>".self::escape($sitemap['loc'])."</loc>\n";

            if (! empty($sitemap['lastmod'])) {
                $xml .= "\t\t<lastmod>".self::formatDate($sitemap['lastmod'])."</lastmod>\n";
            }

            $xml .= "\t</sitemap>\n";
        }

        return $xml.'</sitemapindex>';
    }

    /**
     * Les timestamps de l'application sont stockés en entiers Unix.
     */
    protected static function formatDate(string|int $value): string
    {
        if (is_numeric($value)) {
            return date(DATE_ATOM, (int) $value);
        }

        $timestamp = strtotime($value);

        return $timestamp === false ? self::escape((string) $value) : date(DATE_ATOM, $timestamp);
    }

    protected static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }
}
