<?php

use function Pest\Faker\fake;

use Support\Actions\StripScriptTagsAction;

it('strips script tags from an html string', function () {
    $action = app(StripScriptTagsAction::class);
    $HTML = fake()->randomHtml() . "<script>alert('test')</script>";
    $strippedHTML = $action->execute($HTML);

    $this->assertStringContainsString("<script>alert('test')</script>", $HTML);
    $this->assertStringNotContainsString("<script>alert('test')</script>", $strippedHTML);
});
