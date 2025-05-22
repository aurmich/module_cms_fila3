<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Filament\Resources;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Modules\Media\Filament\Resources\MediaConvertResource;
use Tests\TestCase;

class MediaConvertResourceTest extends TestCase
{
    public function testGetFormSchemaReturnsExpectedComponents(): void
    {
        $schema = MediaConvertResource::getFormSchema();
        $this->assertIsArray($schema);
        $this->assertNotEmpty($schema);
        $componentClasses = array_map(fn ($c) => get_class($c), $schema);
        $this->assertContains(Radio::class, $componentClasses);
        $this->assertContains(TextInput::class, $componentClasses);
    }
}
