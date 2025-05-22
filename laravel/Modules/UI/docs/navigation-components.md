# Componenti Navigazione

## 🧭 Menu Principale

### Navbar
```html
<nav class="navbar">
  <div class="navbar-brand">
    <a href="/">
      <img src="logo.png" alt="Logo">
    </a>
  </div>
  
  <button class="navbar-toggler" aria-label="Menu">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="navbar-collapse">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="/">Home</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button">
          Servizi
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">Servizio 1</a></li>
          <li><a class="dropdown-item" href="#">Servizio 2</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
```

## 📑 Breadcrumbs
```html
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a href="/categoria">Categoria</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
      Pagina Corrente
    </li>
  </ol>
</nav>
```

## 📱 Menu Mobile
```html
<div class="mobile-menu">
  <div class="mobile-menu-header">
    <button class="close-menu" aria-label="Chiudi menu">
      <i class="fas fa-times"></i>
    </button>
  </div>
  
  <nav class="mobile-menu-nav">
    <ul>
      <li class="active">
        <a href="/">
          <i class="fas fa-home"></i>
          Home
        </a>
      </li>
      <li class="has-submenu">
        <a href="#">
          <i class="fas fa-cog"></i>
          Impostazioni
        </a>
        <ul class="submenu">
          <li><a href="#">Profilo</a></li>
          <li><a href="#">Sicurezza</a></li>
        </ul>
      </li>
    </ul>
  </nav>
</div>
```

## 🎯 Paginazione
```html
<nav aria-label="Paginazione">
  <ul class="pagination">
    <li class="page-item disabled">
      <span class="page-link">Precedente</span>
    </li>
    <li class="page-item active">
      <span class="page-link">1</span>
    </li>
    <li class="page-item">
      <a class="page-link" href="#">2</a>
    </li>
    <li class="page-item">
      <a class="page-link" href="#">3</a>
    </li>
    <li class="page-item">
      <a class="page-link" href="#">Successivo</a>
    </li>
  </ul>
</nav>
```

## 🔗 Tabs
```html
<div class="tabs">
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-bs-toggle="tab" href="#tab1">
        Tab 1
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="tab" href="#tab2">
        Tab 2
      </a>
    </li>
  </ul>
  
  <div class="tab-content">
    <div class="tab-pane active" id="tab1">
      Contenuto Tab 1
    </div>
    <div class="tab-pane" id="tab2">
      Contenuto Tab 2
    </div>
  </div>
</div>
```

## 🎨 Stili e Comportamenti

### Dropdown
```scss
.dropdown {
  position: relative;
  
  &-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;
    
    &.show {
      display: block;
    }
  }
}
```

### Mobile Menu
```scss
.mobile-menu {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: white;
  z-index: 1000;
  transform: translateX(-100%);
  transition: transform 0.3s ease;
  
  &.show {
    transform: translateX(0);
  }
}
```

## 🔗 Collegamenti
- [Componenti Base](./base-components.md)
- [Layout](./layout-components.md)
- [Accessibilità](./standards/accessibility.md) 