---
title: Graph
description: Graph
extends: _layouts.documentation
section: content
path: it/project_docs/components
---

# Graph {#graph}

Scarica via API un grafico in Chartjs in formato Json da un Url e lo visualizza

Nome Componente:
```php
x-graph
```

Parametri:

```php
string $id
string $url
?string $type = 'graph' (solo graph per ora)
```

Esempio:

```php
<x-graph
id="1"
url="http://site.xx/chartjs/1"
type = "graph"
>

</x-graph>
```

Per altre informazioni leggere documentazione [ChartJs](https://www.chartjs.org/project_docs/latest/).
## Collegamenti tra versioni di graph.md
* [graph.md](laravel/Modules/Chart/project_docs/components/graph.md)
* [graph.md](laravel/Modules/Cms/project_docs/components/graph.md)

