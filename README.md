# Simple ACF Avatar

## Instalation 
- Install this plugin by uploading to wp-content/plugins
- Create image field `avatar` in Advanced Custom Fields - remember it has to be a image field and have to return ID

## Usage
Simply use WordPress avatars functions. This plugin hooks into `get_avatar_url` to change it.

It works great with Timber's resize filter.

## Filters
`simple_acf_avatar_use_gravatar` - default value `false` - if set to `false` it hide gravatars from admin panel and user edit
`simple_acf_avatar_acf_field_name` - default value `avatar` - the name of the ACF field
`simple_acf_avatar_size` - default value 'thumbnail' - name of image size used. If you want to use a custom size remember to use `add_image_size`
