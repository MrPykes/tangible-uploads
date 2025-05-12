const { registerBlockType } = wp.blocks;
const { RichText } = wp.blockEditor;

registerBlockType("cgb/tangible-block", {
  title: "Tangible Block",
  icon: "smiley",
  category: "media",
  attributes: {
    content: {
      type: "string",
      source: "html",
      selector: "p",
    },
  },
  edit({ attributes, setAttributes }) {
    return wp.element.createElement(RichText, {
      tagName: "p",
      value: attributes.content,
      onChange: (content) => setAttributes({ content }),
      placeholder: "Write something cool...",
    });
  },
  save({ attributes }) {
    return wp.element.createElement(RichText.Content, {
      tagName: "p",
      value: attributes.content,
    });
  },
});
