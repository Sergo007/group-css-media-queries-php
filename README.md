group-css-media-queries-php
=======================

CSS postprocessing: group media queries written on php. Useful for postprocessing preprocessed CSS files.\
This function is a php implementation the [group-css-media-queries](https://github.com/Se7enSky/group-css-media-queries).

# What is it?

You have input.css (take note on similar media query):
```css
.header-main {
  background-image: url("/images/branding/logo.main.png");
}
@media all and (-webkit-min-device-pixel-ratio:1.5),(min--moz-device-pixel-ratio:1.5),(-o-min-device-pixel-ratio:1.5/1),(min-device-pixel-ratio:1.5),(min-resolution:138dpi),(min-resolution:1.5dppx) {
  .header-main {
    background-image: url("/images/branding/logo.main@2x.png");
    -webkit-background-size: auto auto;
    -moz-background-size: auto auto;
    background-size: auto auto;
  }
}
.footer-main {
  background-image: url("/images/branding/logo.main.png");
}
@media all and (-webkit-min-device-pixel-ratio:1.5),(min--moz-device-pixel-ratio:1.5),(-o-min-device-pixel-ratio:1.5/1),(min-device-pixel-ratio:1.5),(min-resolution:138dpi),(min-resolution:1.5dppx) {
  .footer-main {
    background-image: url("/images/branding/logo.main@2x.png");
    -webkit-background-size: auto auto;
    -moz-background-size: auto auto;
    background-size: auto auto;
  }
}
```

Run this utility:
```
group-css-media-queries input.css output.css
```

The result is output.css:
```css
.header-main {
  background-image: url("/images/branding/logo.main.png");
}

.footer-main {
  background-image: url("/images/branding/logo.main.png");
}

@media all and (-webkit-min-device-pixel-ratio:1.5),(min--moz-device-pixel-ratio:1.5),(-o-min-device-pixel-ratio:1.5/1),(min-device-pixel-ratio:1.5),(min-resolution:138dpi),(min-resolution:1.5dppx) {
  .header-main {
    background-image: url("/images/branding/logo.main@2x.png");
    -webkit-background-size: auto auto;
    -moz-background-size: auto auto;
    background-size: auto auto;
  }

  .footer-main {
    background-image: url("/images/branding/logo.main@2x.png");
    -webkit-background-size: auto auto;
    -moz-background-size: auto auto;
    background-size: auto auto;
  }
}
```

Voila!

# How to use

Signature
groupCssMediaQueries(css: String): String

```php
<?php
    require "./lib/group.css.media.queries.php";
    $outputCss = groupCssMediaQueries(file_get_contents('./input.css'))
?>
```

# Media Queries order
Output CSS is ordered by these rules:
* non-media-query code goes first unmodified,
* then all only min-width rules, sorted ascending by px
* then all only max-width rules, sorted descending by px
* then all interval rules, without reordering
* then all other rules
