# Webpack configuration for Wordpress Plugin

`yarn init` and then install dependencies
```sh
yarn add --dev webpack webpack-cli
yarn add --dev babel-loader @babel/core @babel/preset-env @babel/preset-react @babel/cli 
```

Create `enqueue.php` at root
```php
<?php
/**
 * Plugin Name: Test Plugin
 * Description: A description of this plugin
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
  exit;
};

function testplugin_register() {
	wp_register_script(
		'exampleplugin-script',
    plugins_url('/build/index_bundle.js', __FILE__ ),
    array('wp-blocks', 'wp-components', 'wp-element', 'wp-editor', 'wp-i18n')
  );

  wp_register_style(
    'exampleplugin-globalstyle',
    plugins_url( '/build/global-style.css', __FILE__ ),
    array( 'wp-edit-blocks' ),
    // TODO: Remove the line below to use caching
    filemtime( plugin_dir_path( __FILE__ ) . '/blocks/global-style.css' )
  );

  wp_register_style(
    'exampleplugin-editorstyle',
    plugins_url( '/build/editor-style.css', __FILE__ ),
    array( 'wp-edit-blocks' ),
    // TODO: Remove the line below to use caching
    filemtime( plugin_dir_path( __FILE__ ) . '/blocks/editor-style.css' )
  );

  register_block_type( 'testplugin/foobar', array(
    'editor_script' => 'testplugin-script',
    'editor_style' => 'testplugin-editorstyle',
    'style' => 'testplugin-globalstyle',
  ));

  wp_enqueue_script('testplugin-script');
}

add_action( 'enqueue_block_editor_assets', 'testplugin_register' );

```

Create `webpack.config.js`
```js
const path = require('path');

module.exports = {
  module: {
    rules: [
      {
        test: /\.m?(js|jsx)$/,
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: 'babel-loader',
        },
      },
    ],
  },
  entry: './src/index.js',
  output: {
    path: path.resolve(__dirname, './build'),
    filename: 'index_bundle.js',
  },
};

```

Create `.babelrc` at the root
```js
{
  "presets": ["@babel/preset-env", "@babel/preset-react"]
}

```

Add following scripts to `package.json`
```json
"scripts": {
  "build": "webpack --mode production",
  "build:dev": "webpack --mode development --watch"
}
```

Create `src/blocks/block-test/index.jsx`
```js
const { registerBlockType} = wp.blocks;
const { RichText, InnerBlocks } = wp.editor;
const { __ } = wp.i18n;

registerBlockType('testplugin/foobar', {
  title: __('Hello world'),
  description: __('A basic div container'),
  icon: 'layout',
  category: 'common',
  attributes: {
    content: {
      type: 'array',
      source: 'children',
      selector: 'div',
    },
  },

  edit: ( props ) => (
    <div>
      <RichText
        className={ props.className }
        tagName='div'
        onChange={ (content) => props.setAttributes({ content }) }
      />
    </div>
  ),
  save: (props) => (
    <RichText.Content
      tagName='div'
      value={ props.attributes.content }
    />
  )
});

```

Create `src/index.js`
```js
import './blocks/block-test/index.jsx';

```

Install `react` and `prop-types`
```sh
yarn add react prop-types
```

Add `.eslintrc`
```json
{
  "parserOptions": {
    "ecmaVersion": 7,
    "sourceType": "module",
    "ecmaFeatures": {
      "jsx": true
    }
  }
}
```