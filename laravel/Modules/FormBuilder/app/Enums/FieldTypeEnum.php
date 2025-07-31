<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Enums;

enum FieldTypeEnum: string
{
    case TEXT = 'text';
    case TEXTAREA = 'textarea';
    case EMAIL = 'email';
    case PASSWORD = 'password';
    case NUMBER = 'number';
    case SELECT = 'select';
    case CHECKBOX = 'checkbox';
    case RADIO = 'radio';
    case FILE = 'file';
    case DATE = 'date';
    case DATETIME = 'datetime';
    case TIME = 'time';
    case URL = 'url';
    case TEL = 'tel';
    case HIDDEN = 'hidden';
    case RICH_EDITOR = 'rich_editor';
    case MARKDOWN = 'markdown';
    case COLOR = 'color';
    case RANGE = 'range';
    case SEARCH = 'search';



    public function getLabel(): string
    {
        return match($this) {
            self::TEXT => 'Testo',
            self::TEXTAREA => 'Area di testo',
            self::EMAIL => 'Email',
            self::PASSWORD => 'Password',
            self::NUMBER => 'Numero',
            self::SELECT => 'Selezione',
            self::CHECKBOX => 'Checkbox',
            self::RADIO => 'Radio',
            self::FILE => 'File',
            self::DATE => 'Data',
            self::DATETIME => 'Data e ora',
            self::TIME => 'Ora',
            self::URL => 'URL',
            self::TEL => 'Telefono',
            self::HIDDEN => 'Nascosto',
            self::RICH_EDITOR => 'Editor di testo',
            self::MARKDOWN => 'Markdown',
            self::COLOR => 'Colore',
            self::RANGE => 'Intervallo',
            self::SEARCH => 'Ricerca',
        };
    }
} 