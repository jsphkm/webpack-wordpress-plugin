import React from 'react';

const { registerBlockType } = window.wp.blocks;
const { RichText } = window.wp.editor;
const { __ } = window.wp.i18n;

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

  edit: (props) => {
    const { className } = props;
    return (
      <div>
        <RichText
          className={className}
          tagName="div"
          onChange={content => props.setAttributes({ content })}
        />
      </div>
    );
  },
  save: (props) => {
    const { attributes: content } = props;
    return (
      <RichText.Content
        tagName="div"
        value={content}
      />
    );
  },
});
