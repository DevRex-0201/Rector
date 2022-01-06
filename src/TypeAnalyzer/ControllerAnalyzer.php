<?php

declare(strict_types=1);

namespace Rector\Symfony\TypeAnalyzer;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ThisType;
use PHPStan\Type\TypeWithClassName;
use Rector\NodeTypeResolver\Node\AttributeKey;

final class ControllerAnalyzer
{
    public function isController(Node\Expr $expr): bool
    {
        $scope = $expr->getAttribute(AttributeKey::SCOPE);

        // might be missing in a trait
        if (! $scope instanceof Scope) {
            return false;
        }

        $nodeType = $scope->getType($expr);
        if (! $nodeType instanceof TypeWithClassName) {
            return false;
        }

        if ($nodeType instanceof ThisType) {
            $nodeType = $nodeType->getStaticObjectType();
        }

        if (! $nodeType instanceof ObjectType) {
            return false;
        }

        $classReflection = $nodeType->getClassReflection();
        if (! $classReflection instanceof ClassReflection) {
            return false;
        }

        return $this->isControllerClassReflection($classReflection);
    }

    public function isInsideController(Node $node): bool
    {
        $scope = $node->getAttribute(AttributeKey::SCOPE);

        // might be missing in a trait
        if (! $scope instanceof Scope) {
            return false;
        }

        $classReflection = $scope->getClassReflection();
        if (! $classReflection instanceof ClassReflection) {
            return false;
        }

        return $this->isControllerClassReflection($classReflection);
    }

    private function isControllerClassReflection(ClassReflection $classReflection): bool
    {
        if ($classReflection->isSubclassOf('Symfony\Bundle\FrameworkBundle\Controller\Controller')) {
            return true;
        }

        return $classReflection->isSubclassOf('Symfony\Bundle\FrameworkBundle\Controller\AbstractController');
    }
}
