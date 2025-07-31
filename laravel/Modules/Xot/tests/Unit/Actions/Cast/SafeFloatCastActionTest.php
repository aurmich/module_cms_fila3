<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Cast;

use Modules\Xot\Actions\Cast\SafeFloatCastAction;
use Tests\TestCase;

/**
 * Test per SafeFloatCastAction.
 */
class SafeFloatCastActionTest extends TestCase
{
    private SafeFloatCastAction $action;

    protected function setUp(): void
    {
        parent::setUp();
        $this->action = app(SafeFloatCastAction::class);
    }

    /**
     * Test conversione di valori float.
     */
    public function test_cast_float_value(): void
    {
        $result = $this->action->execute(123.45);
        $this->assertEquals(123.45, $result);
        $this->assertIsFloat($result);
    }

    /**
     * Test conversione di valori interi.
     */
    public function test_cast_int_value(): void
    {
        $result = $this->action->execute(123);
        $this->assertEquals(123.0, $result);
        $this->assertIsFloat($result);
    }

    /**
     * Test conversione di valori null.
     */
    public function test_cast_null_value(): void
    {
        $result = $this->action->execute(null);
        $this->assertEquals(0.0, $result);
        $this->assertIsFloat($result);
    }

    /**
     * Test conversione di valori null con default personalizzato.
     */
    public function test_cast_null_with_custom_default(): void
    {
        $result = $this->action->execute(null, 10.0);
        $this->assertEquals(10.0, $result);
        $this->assertIsFloat($result);
    }

    /**
     * Test conversione di stringhe numeriche.
     */
    public function test_cast_numeric_string(): void
    {
        $result = $this->action->execute('123.45');
        $this->assertEquals(123.45, $result);
        $this->assertIsFloat($result);
    }

    /**
     * Test conversione di stringhe intere.
     */
    public function test_cast_integer_string(): void
    {
        $result = $this->action->execute('123');
        $this->assertEquals(123.0, $result);
        $this->assertIsFloat($result);
    }

    /**
     * Test conversione di stringhe vuote.
     */
    public function test_cast_empty_string(): void
    {
        $result = $this->action->execute('');
        $this->assertEquals(0.0, $result);
        $this->assertIsFloat($result);
    }

    /**
     * Test conversione di stringhe con spazi.
     */
    public function test_cast_whitespace_string(): void
    {
        $result = $this->action->execute('  123.45  ');
        $this->assertEquals(123.45, $result);
        $this->assertIsFloat($result);
    }

    /**
     * Test conversione di stringhe non numeriche.
     */
    public function test_cast_non_numeric_string(): void
    {
        $result = $this->action->execute('abc');
        $this->assertEquals(0.0, $result);
        $this->assertIsFloat($result);
    }

    /**
     * Test conversione di stringhe non numeriche con default.
     */
    public function test_cast_non_numeric_string_with_default(): void
    {
        $result = $this->action->execute('abc', 5.0);
        $this->assertEquals(5.0, $result);
        $this->assertIsFloat($result);
    }

    /**
     * Test conversione di valori booleani.
     */
    public function test_cast_boolean_values(): void
    {
        $trueResult = $this->action->execute(true);
        $this->assertEquals(1.0, $trueResult);
        $this->assertIsFloat($trueResult);

        $falseResult = $this->action->execute(false);
        $this->assertEquals(0.0, $falseResult);
        $this->assertIsFloat($falseResult);
    }

    /**
     * Test conversione di array.
     */
    public function test_cast_array(): void
    {
        $result = $this->action->execute([1, 2, 3]);
        $this->assertEquals(0.0, $result);
        $this->assertIsFloat($result);
    }

    /**
     * Test conversione di oggetti.
     */
    public function test_cast_object(): void
    {
        $result = $this->action->execute(new \stdClass());
        $this->assertEquals(0.0, $result);
        $this->assertIsFloat($result);
    }

    /**
     * Test conversione con range validation.
     */
    public function test_cast_with_range(): void
    {
        // Valore normale
        $result = $this->action->executeWithRange(50.0, 0.0, 100.0);
        $this->assertEquals(50.0, $result);

        // Valore sopra il massimo
        $result = $this->action->executeWithRange(150.0, 0.0, 100.0);
        $this->assertEquals(100.0, $result);

        // Valore sotto il minimo
        $result = $this->action->executeWithRange(-10.0, 0.0, 100.0);
        $this->assertEquals(0.0, $result);
    }

    /**
     * Test conversione con range e default.
     */
    public function test_cast_with_range_and_default(): void
    {
        $result = $this->action->executeWithRange('invalid', 0.0, 100.0, 25.0);
        $this->assertEquals(25.0, $result);
    }

    /**
     * Test metodo statico cast.
     */
    public function test_static_cast_method(): void
    {
        $result = SafeFloatCastAction::cast('123.45');
        $this->assertEquals(123.45, $result);
        $this->assertIsFloat($result);
    }

    /**
     * Test metodo statico cast con default.
     */
    public function test_static_cast_method_with_default(): void
    {
        $result = SafeFloatCastAction::cast(null, 10.0);
        $this->assertEquals(10.0, $result);
        $this->assertIsFloat($result);
    }

    /**
     * Test metodo statico castWithRange.
     */
    public function test_static_cast_with_range(): void
    {
        $result = SafeFloatCastAction::castWithRange('150.0', 0.0, 100.0);
        $this->assertEquals(100.0, $result);
        $this->assertIsFloat($result);
    }

    /**
     * Test gestione di numeri infiniti.
     */
    public function test_cast_infinite_values(): void
    {
        $result = $this->action->execute('INF');
        $this->assertEquals(0.0, $result);

        $result = $this->action->execute('NAN');
        $this->assertEquals(0.0, $result);
    }

    /**
     * Test gestione di numeri infiniti con default.
     */
    public function test_cast_infinite_values_with_default(): void
    {
        $result = $this->action->execute('INF', 5.0);
        $this->assertEquals(5.0, $result);

        $result = $this->action->execute('NAN', 5.0);
        $this->assertEquals(5.0, $result);
    }

    /**
     * Test valori numerici con notazione scientifica.
     */
    public function test_cast_scientific_notation(): void
    {
        $result = $this->action->execute('1.23e2');
        $this->assertEquals(123.0, $result);

        $result = $this->action->execute('1.23E-2');
        $this->assertEquals(0.0123, $result);
    }

    /**
     * Test valori con virgola decimale.
     */
    public function test_cast_decimal_comma(): void
    {
        // Nota: PHP non riconosce automaticamente la virgola come separatore decimale
        $result = $this->action->execute('123,45');
        $this->assertEquals(0.0, $result);
    }
} 