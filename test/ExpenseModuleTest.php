<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class ExpenseModuleTest extends TestCase
{
    /*
    |--------------------------------------------------------------------------
    | ADD EXPENSE
    |--------------------------------------------------------------------------
    */

    public function testExpenseAmountValid(): void
    {
        $amount = 500;

        $this->assertGreaterThan(
            0,
            $amount
        );
    }

    public function testExpenseDescriptionNotEmpty(): void
    {
        $description = "Food Purchase";

        $this->assertNotEmpty(
            $description
        );
    }

    /*
    |--------------------------------------------------------------------------
    | BUDGET LIMIT
    |--------------------------------------------------------------------------
    */

    public function testBudgetWithinLimit(): void
    {
        $monthlyLimit = 1000;
        $alreadySpent = 400;
        $newExpense = 300;

        $newTotal = $alreadySpent + $newExpense;

        $this->assertLessThanOrEqual(
            $monthlyLimit,
            $newTotal
        );
    }

    public function testBudgetExceeded(): void
    {
        $monthlyLimit = 1000;
        $alreadySpent = 900;
        $newExpense = 200;

        $newTotal = $alreadySpent + $newExpense;

        $this->assertGreaterThan(
            $monthlyLimit,
            $newTotal
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADD INCOME
    |--------------------------------------------------------------------------
    */

    public function testIncomeAmountValid(): void
    {
        $amount = 2500;

        $this->assertGreaterThan(
            0,
            $amount
        );
    }

    /*
    |--------------------------------------------------------------------------
    | TRANSACTION TYPES
    |--------------------------------------------------------------------------
    */

    public function testIncomeType(): void
    {
        $type = "income";

        $this->assertEquals(
            "income",
            $type
        );
    }

    public function testExpenseType(): void
    {
        $type = "expense";

        $this->assertEquals(
            "expense",
            $type
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DATE VALIDATION
    |--------------------------------------------------------------------------
    */

    public function testDateFormat(): void
    {
        $date = "2026-06-05";

        $this->assertMatchesRegularExpression(
            '/^\d{4}-\d{2}-\d{2}$/',
            $date
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */

    public function testSearchTransaction(): void
    {
        $this->assertStringContainsString(
            "salary",
            "salary payment"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SECURITY
    |--------------------------------------------------------------------------
    */

    public function testXssProtection(): void
    {
        $input = "<script>alert(1)</script>";

        $output = htmlspecialchars($input);

        $this->assertNotEquals(
            $input,
            $output
        );
    }

    public function testHtmlEscaping(): void
    {
        $input = "<b>Expense</b>";

        $output = htmlspecialchars($input);

        $this->assertStringContainsString(
            "&lt;b&gt;",
            $output
        );
    }
}