<?php

it('lists the colors', function () {
    $this->artisan('color:list')->assertExitCode(0);
});
