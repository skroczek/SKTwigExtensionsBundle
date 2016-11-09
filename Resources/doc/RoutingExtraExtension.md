Routing Extra Extension 
=======================

Activate routing extra extension:

```yml
sk_twig_extensions:
    extensions:
        routing_extra_extension: true
```
## Functions

### Function link
#### Description
```
{{ link(string route, string text [, array routeParameter = array() [, array attr = array() ]] ) }}
```
Generate a html anchor element based on a symfony route.

#### Parameters
##### route
The name of the route.

##### text
The link text.

##### routeParameter
Optional route parameter.

##### attr
Optional attributes. The values are not validated.

#### Example
```twig
{{ link("homepage", "Home", {}, {"class": "foo"}) }}
{{ link("route_with_paramter", "Route with parameter", {"parma1": "1"}, {"class": "foo"}) }}
```

##### Output:
```html
<a href="/" class="foo">Home</a>
<a href="/route/with/parameter/1" class="foo">Route with parameter</a>
```