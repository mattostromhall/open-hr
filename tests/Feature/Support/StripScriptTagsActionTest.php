<?php

use function Pest\Faker\faker;

use Support\Actions\StripScriptTagsAction;

it('strips script tags from an html string', function () {
    $action = app(StripScriptTagsAction::class);
    $HTML = faker()->randomHtml() . "<script>alert('test')</script>";
    $strippedHTML = $action->execute($HTML);

    $this->assertStringContainsString("<script>alert('test')</script>", $HTML);
    $this->assertStringNotContainsString("<script>alert('test')</script>", $strippedHTML);
});
