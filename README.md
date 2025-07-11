# Post metadata bindings

This plugin makes post metadata from query loops available through the [block bindings API](https://developer.wordpress.org/block-editor/reference-guides/block-api/block-bindings/) in Wordpress.

This plugin implements code by [\@BenceSalazai](https://github.com/BenceSzalai) in [#42261](https://github.com/WordPress/gutenberg/issues/42261#issuecomment-2526409680), which will likely make it to WordPress core. Who knows, it could already be there for all I know. But this works too.

## Installation

#### Basic:

Download the plugin .zip from the releases page and upload to WordPress. 

#### Composer:
Add the following repository to your composer.json file:

``` json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/alexbracken/post-meta-bindings.git"
    }
]
```

And then install the plugin with ```composer require alexbracken/post-meta-bindings```.

## Usage

Available metadata is listed below and bound through the `post/meta-bindings` source.

To use in the source editor: Replace `[ATTRIBUTE]` with the attribute of the block you're replacing, and `[KEY]` with the value from the table below.

``` html
{"metadata":{"bindings":{"[ATTRIBUTE]":{"source":"post/meta-bindings","args":{"key":"[KEY]"}}}}}
```

### Key reference

| Key | Value | Function |
|-----------------|---------------------------|---------------------------|
| `url` | Permalink of the current post | `get_permalink()` |
| `title` | Title of the current post | `get_the_title()` |
| `excerpt` | Excerpt of the current post | `get_the_excerpt()` |
| `featured_image_url` | URL of the current post's featured image | `get_the_post_thumbnail_url()` |
| `published_date` | Published date of the current post | `get_the_date()` |
| `modified_date` | Modified date of the current post | `get_the_modified_date()` |

Notes:
These keys can be used to replace block data as described in the [block bindings reference guide](https://developer.wordpress.org/block-editor/reference-guides/block-api/block-bindings/#compatible-blocks-and-their-attributes). As of v6.8.1, these keys can replace attributes from the paragraph, heading, image, and button blocks.

### Example usage:

Replace a button's `url` attribute with the current post's permalink.

``` html
<!-- wp:button {
    "metadata":{
        "bindings":{
            "url":{
                "source": "post/meta-bindings",
                "args":{ "key":"url" }
            }
        }
    }
-->
```