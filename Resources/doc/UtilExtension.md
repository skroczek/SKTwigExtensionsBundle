Util Extension
==============
Activate util extension:

```yml
sk_twig_extensions:
    extensions:
        util_extension: true
```

## Filter
### Filter each
#### Description
```
{{ mixed value | each( string filterName [, array filterArgs = array()] ) }}
```
Handy filter to apply a filter to every element of an array.
#### Parameters
##### value
Array or object implementing \Traversable interface.

##### filterName
Name of the filter which sould be applied to each element.

##### filterArgs
Optional filter arguments.

#### Example
```twig
<span>{{ {1024, 1073741824} | each("format_bytes") | join(", ") }}</span>
```
##### Output:

```html
<span>1.0 Kib, 1.0 GiB</span>
```

### Filter wrap
#### Description
```
{{ string value | wrap( [pre = '' [, post = '']] ) }}
```
Simple filter to wrap a string within another.

#### Parameters
##### value
String value to be wrapped

##### pre
String to prepend to value string.

##### post
String to append to value string.

#### Example
```twig
{{ {1024, 1073741824} | each("format_bytes") | each("wrap", "<span>", "</span>") | join(" ") }}
```
##### Output:

```html
<span>1.0 Kib</span> <span>1.0 GiB</span>
``` 
