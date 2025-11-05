<?php

declare(strict_types=1);

namespace Rule;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use ReflectionClass;
use Sal\PhpstanReadonlyEnforcing\Rules\EnforceReadonlyRule;
use Sal\PhpstanReadonlyEnforcing\Test\Dummy\Mixed\Mixed_PromotedPartialReadonly;
use Sal\PhpstanReadonlyEnforcing\Test\Dummy\Mixed\Mixed_PromotedReadonly_WithTraditional;
use Sal\PhpstanReadonlyEnforcing\Test\Dummy\Promoted\Abstract_NonReadonly_PromotedAllShouldBeReadonly;
use Sal\PhpstanReadonlyEnforcing\Test\Dummy\Promoted\Abstract_NonReadonly_PromotedOneReadonly;
use Sal\PhpstanReadonlyEnforcing\Test\Dummy\Promoted\Abstract_Readonly_PromotedAllReadonly;
use Sal\PhpstanReadonlyEnforcing\Test\Dummy\Promoted\Promoted_NonReadonlyClass_AllShouldBeReadonly;
use Sal\PhpstanReadonlyEnforcing\Test\Dummy\Promoted\Promoted_NonReadonlyClass_OneReadonly;

class EnforceReadonlyRuleWithoutReadonlyClassTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new EnforceReadonlyRule(false);
    }

    public function testPromotedReadonlyClass(): void
    {
        $this->analyseClass(Promoted_NonReadonlyClass_AllShouldBeReadonly::class, [
            ['The property "$name" should be readonly.', 8],
            ['The property "$id" should be readonly.', 9],
        ]);

        $this->analyseClass(Promoted_NonReadonlyClass_OneReadonly::class, [
            ['The property "$id" should be readonly.', 9],
        ]);

        $this->analyseClass(Abstract_NonReadonly_PromotedAllShouldBeReadonly::class, [
            ['The property "$logger" should be readonly.', 10],
            ['The property "$name" should be readonly.', 11],
        ]);

        $this->analyseClass(Abstract_NonReadonly_PromotedOneReadonly::class, [
            ['The property "$name" should be readonly.', 11],
        ]);

        $this->analyseClass(Abstract_Readonly_PromotedAllReadonly::class, []);
    }

    public function testMixed(): void
    {
        $this->analyseClass(Mixed_PromotedPartialReadonly::class, [
            ['The property "$name" should be readonly.', 9],
        ]);

        $this->analyseClass(Mixed_PromotedReadonly_WithTraditional::class, []);
    }

    private function analyseClass(string $className, array $expectedErrors): void
    {
        $reflector = new ReflectionClass($className);
        $this->analyse([$reflector->getFileName()], $expectedErrors);
    }
}
