Util Extension
==============
Activate util extension:

```yml
sk_twig_extensions:
    extensions:
        string_extension: true
```

## Filter
### Filter ucfirst
#### Description
```
{{ string value | ucfirst }}
```
Make a string's first character uppercase.

This is a simple wrapper for the php [ucfirst](http://php.net/manual/en/function.ucfirst.php) function.

#### Parameters
##### value
A string or an object implementing __toString magic method

#### Example
```twig
<span>{{ "hello World" | ucfirst }}</span>
```
##### Output:

```html
<span>Hello World</span>
```

### Filter lcfirst
#### Description
```
{{ string value | lcfirst }}
```
Make a string's first character lowercase.

This is a simple wrapper for the php [lcfirst](http://php.net/manual/en/function.lcfirst.php) function.

#### Parameters
##### value
A string or an object implementing __toString magic method

#### Example
```twig
<span>{{ "Hello World" | lcfirst }}</span>
```
##### Output:

```html
<span>hello World</span>
```

## Functions
### Function ucfirst
#### Description
```
{{ ucfirst( string value ) }}
```
Make a string's first character uppercase.

This is a simple wrapper for the php [ucfirst](http://php.net/manual/en/function.ucfirst.php) function.

#### Parameters
##### value
A string or an object implementing __toString magic method

#### Example
```twig
<span>{{ ucfirst( "hello World" ) }}</span>
```
##### Output:

```html
<span>Hello World</span>
```

### Function lcfirst
#### Description
```
{{ lcfirst( string value ) }}
```
Make a string's first character lowercase.

This is a simple wrapper for the php [lcfirst](http://php.net/manual/en/function.lcfirst.php) function.

#### Parameters
##### value
A string or an object implementing __toString magic method

#### Example
```twig
<span>{{ lcfirst( "Hello World" ) }}</span>
```
##### Output:

```html
<span>hello World</span>
```
