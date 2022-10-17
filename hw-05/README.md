# Úkol 5: Faktury

Cílem je vytvořit program, který bude generovat faktury jako PDF dokumenty. Máte připravenou kostru aplikace, kde najdete třídy reprezentující věci vyskytující se na faktuře a třídu `Builder`, která slouží k vytvoření faktury. Do projektu doinstalujte pomocí composeru knihovnu [DomPDF](https://github.com/dompdf/dompdf). Pokud z nějakého důvodu chcete použít knihovnu jinou, po domluvě s cvičícím, kterému úkoly odevzdáváte, je to také možné.

Doplňte chybějící části tříd `Invoice\Item`, `Builder` a `Invoice`.

Dále implementujte třídu `Renderer`, tak aby vytvořila PDF fakturu. K testování můžete použít skript `run.php`:

```
$ php run.php > invoice.pdf
```
Pokud vám PDF nejde otevřít, a nevidíte ani žádnou chybu, zkuste provést spuštění programu bez přesměrování výstupu - pravděpodobně se vypisuje chyba, ale namísto na STDOUT jde právě do souboru invoice.pdf
```
$ php run.php
```

Soubor `template.pdf` ukazuje, jak by výsledná faktura měla vypadat. Vaším úkolem je použít knihovnu DomPDF tak, abyste se co nejvíc přiblížili ukázce. Bude potřeba se podívat do dokumentace knihovny, abyste zjistili, jak ji použít. Není potřeba řešit podporu českých znaků.

Bodové hodnocení jednotlivých částí je následující:

- Nainstalování knihovny DomPDF a vyprodukování PDF souboru, který jde otevřít **[1 bod]**
- Faktura obsahuje všechna požadovaná data **[2 body]**
- Vzhled faktury:
	- Dodavatel a odběratel s příslušným formátováním (telefonní číslo a email se zobrazí pouze pokud jsou nastavené) **[1 bod]**
	- Tabulka položek (správné zarámování, tučná hlavička a řádek celkem, zarovnání) **[1,5 bodu]**
	- Formátování cen na dvě desetinná místa, s desetinnou čárkou a tisíce oddělené mezerou **[0,5 bodu]**

_Pokud chcete, můžete využít oblíbený šablonovací systém (inspirace třeba [zde](https://ourcodeworld.com/articles/read/847/top-7-best-open-source-php-template-engines)), nebo se naučit nový. Pro plné splnění zadání to ale není nutné._
