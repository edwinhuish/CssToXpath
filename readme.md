# CssToPath

This is a library to translate various CSS selectors to their XPath equivalent.

## Example

```php

// Will output //*[contains(concat(' ', normalize-space(@class), ' '), ' node ')]
echo CssToXpath::transform('.node');

// Will output //*[@id='someid']
echo $translator->translate('#someid');

```

## Installation

You can add this library as a local, per-project dependency to your project using Composer:

```
composer require edwinhuish/css-to-xpath
```

## Selectors supported

The following selectors are currently covered:

- #id
- tag#id
- tag #id
- tag
- tag tag
- tag > tag
- tag + tag
- tag ~ tag
- tag, tag
- .classname
- tag.classname
- tag .classname
- tag.classname, tag.classname
- tag.classname tag.classname
- tag.classname > tag.classname
- tag#id + tag > tag
- tag[id]:contains(Selectors)
- tag[attribute][attribute]
- tag[attribute]
- tag[attribute=example]
- tag[attribute^=exa]
- tag[class$=mple]
- tag[attribute*=e]
- tag[attribute|=dialog]
- tag[attribute!=made_up]
- tag[attribute!="made_up"]
- tag[attribute~=example]
- tag:not(.classname)
- tag:contains(selectors)
- tag:nth-child(n)
- tag:nth-child(even)
- tag:nth-child(odd)
- tag:nth-child(3n+8)
- tag:nth-child(2n+1)
- tag:nth-child(3)
- tag:nth-child(4n)
- tag:only-child
- tag:last-child
- tag:first-child
- foo|bar
- tag[attribute^=exa][attribute$=mple]
- :empty
- :root
- :even
- :odd
- :first-child
- :last-child
- :only-child
- :parent
- :first
- :last
- :header
- :not(foo)
- :has(foo)
- :contains(foo)

## Jquery selector support:
- :eq(2)
- :eq(-5)
- :gt(4)
- :lt(8)
