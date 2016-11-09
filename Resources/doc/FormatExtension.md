Format Extension
================
## Filter

Activate format extension:

```yml
sk_twig_extensions:
    extensions:
        format_extension: true
```
### Filter format_bytes
#### Description

```
{{ bytes | format_bytes([bool si = false [, bool strict = false]] ) }}
```
Format bytes automatic into a more human readable format with units (kB/KiB, MB/MiB, ... , ZB/ZiB, YB/YiB).

#### Parameters

##### bytes
The numeric value to process

##### si
Use 1024 (false) or 1000 (true) as base.

##### strict
Ignore si for small values. Setting "strict" to true while "si" is set to false, will cause 1000 to be rendered as
"1000 B" instead of "1 KiB", which is not really correct, but more human readable.

#### Example

```twig
<span>{{ 1024 | format_bytes }}</span>
<span>{{ 1073741824 | format_bytes }}</span>
<span>{{ 1073741824 | format_bytes(true) }}</span>
```
#### Output:
```html
<span>1.0 KiB</span>
<span>1.0 GiB</span>
<span>1.1 GiB</span>
```

### Filter repeat
#### Description

```
{{ input | string_repeat(integer multiplier) }}
```
Wrapper for php build in function string_repeat.

#### Parameters

##### input
The string to be repeated. 

##### multiplier
Number of time the input string should be repeated.
multiplier has to be greater than or equal to 0. If the multiplier is set to 0, the function will return an empty string.


#### Example

```twig
<span>{{ "-=" | repeat(10) }}</span>
```
#### Output:
```html
<span>-=-=-=-=-=-=-=-=-=-=</span>
```

## Functions

### Function format_bytes
#### Description

```
{{ format_bytes(integer bytes, [bool si = false [, bool strict = false]] ) }}
```
Format bytes automatic into a more human readable format with units (kB/KiB, MB/MiB, ... , ZB/ZiB, YB/YiB).

#### Parameters

##### bytes
The numeric value to process

##### si
Use 1024 (false) or 1000 (true) as base.

##### strict
Ignore si for small values. Setting "strict" to true while "si" is set to false, will cause 1000 to be rendered as
"1000 B" instead of "1 KiB", which is not really correct, but more human readable.

#### Example

```twig
<span>{{ format_bytes(1024) }}</span>
<span>{{ format_bytes(1073741824) }}</span>
<span>{{ format_bytes(1073741824, true) }}</span>
```
#### Output:
```html
<span>1.0 KiB</span>
<span>1.0 GiB</span>
<span>1.1 GiB</span>
```
### Function string_repeat
#### Description

```
{{ string_repeat(string input, integer multiplier) }}
```
Wrapper for php build in function string_repeat.

#### Parameters

##### input
The string to be repeated. 

##### multiplier
Number of time the input string should be repeated.
multiplier has to be greater than or equal to 0. If the multiplier is set to 0, the function will return an empty string.

#### Example

```twig
<span>{{ repeat("-=", 10) }}</span>
```
#### Output:
```html
<span>-=-=-=-=-=-=-=-=-=-=</span>
```