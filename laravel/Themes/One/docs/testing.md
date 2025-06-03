# Sistema di Testing

## Introduzione

Questo documento descrive il sistema di testing del tema "One", inclusi i test unitari, di integrazione e di accessibilità.

## Struttura Testing

```
tests/
├── Unit/
│   ├── Components/
│   ├── Utilities/
│   └── Helpers/
├── Integration/
│   ├── Layouts/
│   ├── Pages/
│   └── Features/
├── Accessibility/
│   ├── Components/
│   └── Pages/
└── jest.config.js
```

## Configurazione Jest

### jest.config.js
```javascript
module.exports = {
  preset: 'jest-preset-stylelint',
  testEnvironment: 'jsdom',
  moduleNameMapper: {
    '\\.(css|less|scss|sass)$': 'identity-obj-proxy',
    '\\.(jpg|jpeg|png|gif|eot|otf|webp|svg|ttf|woff|woff2|mp4|webm|wav|mp3|m4a|aac|oga)$':
      '<rootDir>/__mocks__/fileMock.js',
  },
  setupFilesAfterEnv: ['<rootDir>/jest.setup.js'],
  collectCoverageFrom: [
    'resources/**/*.{js,jsx,ts,tsx}',
    '!resources/**/*.d.ts',
    '!resources/**/*.stories.{js,jsx,ts,tsx}',
  ],
  coverageThreshold: {
    global: {
      branches: 80,
      functions: 80,
      lines: 80,
      statements: 80,
    },
  },
};
```

## Test Unitari

### Componenti
```javascript
// tests/Unit/Components/Button.test.js
import { render, screen } from '@testing-library/react';
import Button from '../../../resources/js/components/Button';

describe('Button', () => {
  test('rende correttamente', () => {
    render(<Button>Test</Button>);
    expect(screen.getByRole('button')).toBeInTheDocument();
  });

  test('applica varianti', () => {
    render(<Button variant="primary">Test</Button>);
    expect(screen.getByRole('button')).toHaveClass('button--primary');
  });

  test('gestisce click', () => {
    const handleClick = jest.fn();
    render(<Button onClick={handleClick}>Test</Button>);
    screen.getByRole('button').click();
    expect(handleClick).toHaveBeenCalledTimes(1);
  });
});
```

### Utility
```javascript
// tests/Unit/Utilities/theme.test.js
import { getTheme, setTheme } from '../../../resources/js/utils/theme';

describe('Theme Utils', () => {
  beforeEach(() => {
    localStorage.clear();
  });

  test('getTheme restituisce default', () => {
    expect(getTheme()).toBe('light');
  });

  test('setTheme salva correttamente', () => {
    setTheme('dark');
    expect(localStorage.getItem('theme')).toBe('dark');
  });
});
```

## Test di Integrazione

### Layout
```javascript
// tests/Integration/Layouts/MainLayout.test.js
import { render, screen } from '@testing-library/react';
import MainLayout from '../../../resources/js/layouts/MainLayout';

describe('MainLayout', () => {
  test('rende header e footer', () => {
    render(
      <MainLayout>
        <div>Content</div>
      </MainLayout>
    );
    
    expect(screen.getByRole('banner')).toBeInTheDocument();
    expect(screen.getByRole('contentinfo')).toBeInTheDocument();
    expect(screen.getByText('Content')).toBeInTheDocument();
  });
});
```

### Features
```javascript
// tests/Integration/Features/Navigation.test.js
import { render, screen, fireEvent } from '@testing-library/react';
import Navigation from '../../../resources/js/features/Navigation';

describe('Navigation', () => {
  test('navigazione funziona correttamente', () => {
    render(<Navigation />);
    
    const homeLink = screen.getByText('Home');
    fireEvent.click(homeLink);
    
    expect(window.location.pathname).toBe('/');
  });
});
```

## Test di Accessibilità

### Componenti
```javascript
// tests/Accessibility/Components/Modal.test.js
import { render, screen } from '@testing-library/react';
import { axe } from 'jest-axe';
import Modal from '../../../resources/js/components/Modal';

describe('Modal Accessibility', () => {
  test('è accessibile', async () => {
    const { container } = render(
      <Modal isOpen={true}>
        <div>Content</div>
      </Modal>
    );
    
    const results = await axe(container);
    expect(results).toHaveNoViolations();
  });

  test('gestisce focus correttamente', () => {
    render(
      <Modal isOpen={true}>
        <button>Close</button>
      </Modal>
    );
    
    expect(screen.getByRole('dialog')).toHaveFocus();
  });
});
```

### Pagine
```javascript
// tests/Accessibility/Pages/Home.test.js
import { render } from '@testing-library/react';
import { axe } from 'jest-axe';
import Home from '../../../resources/js/pages/Home';

describe('Home Page Accessibility', () => {
  test('è accessibile', async () => {
    const { container } = render(<Home />);
    const results = await axe(container);
    expect(results).toHaveNoViolations();
  });
});
```

## Best Practices

### Testing
- Scrivere test atomici
- Utilizzare descrizioni chiare
- Testare edge cases
- Mantenere test indipendenti
- Aggiornare test con il codice

### Performance
- Ottimizzare setup
- Utilizzare mock appropriati
- Gestire risorse
- Monitorare tempi
- Automatizzare processi

### Manutenzione
- Documentare test
- Rivedere regolarmente
- Aggiornare dipendenze
- Gestire configurazioni
- Monitorare coverage

## Metriche di Successo

### Qualità
- Coverage del codice
- Stabilità test
- Manutenibilità
- Documentazione
- Performance

### Accessibilità
- Conformità WCAG
- Supporto screen reader
- Navigazione tastiera
- Contrasto colori
- Test automatici

## Collegamenti

- [Sistema di Design](../design_system.md)
- [Componenti](../components.md)
- [Guida allo Stile](../style_guide.md)
- [Best Practices](../best_practices.md) 
