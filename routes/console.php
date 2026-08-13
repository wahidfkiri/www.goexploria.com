<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('nav:cache')->twiceDaily();
Schedule::command('location:cache')->twiceDaily();
