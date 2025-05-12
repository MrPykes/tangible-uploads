const { registerBlockType } = wp.blocks;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, SelectControl } = wp.components;
const { Fragment, createElement } = wp.element;

registerBlockType("tangible/test-dropdown", {
  title: "Tangible File Upload",
  icon: "book",
  category: "embed",

  attributes: {
    selectedFile: { type: "string", default: "" },
  },

  edit({ attributes, setAttributes }) {
    const files = [
      { label: "Select a file", value: "" },
      {
        label: "Ebook One",
        value:
          "/wp-content/uploads/tangible-embeddable-uploads/Flip%20book/Geo%20Apps%20Stacks%20Flipbook.html",
      },
      {
        label: "Ebook Two",
        value: "/wp-content/uploads/ebooks/ebook-two/index.html",
      },
      {
        label: "Ebook Three",
        value: "/wp-content/uploads/ebooks/ebook-three/index.html",
      },
    ];

    return createElement(
      Fragment,
      {},
      // Sidebar controls (optional)
      createElement(
        InspectorControls,
        {},
        createElement(
          PanelBody,
          { title: "E-Book Settings", initialOpen: true },
          createElement(SelectControl, {
            label: "Select E-Book File",
            value: attributes.selectedFile,
            options: files,
            onChange: (value) => {
              console.log("Selected file:", value);
              setAttributes({ selectedFile: value });
            },
          })
        )
      ),

      // Main block area dropdown (THIS makes it visible directly in editor)
      // createElement(SelectControl, {
      //   label: "Tangible Uploads",
      //   value: attributes.selectedFile,
      //   options: files,
      //   onChange: (value) => {
      //     setAttributes({ selectedFile: value });
      //   },
      // }),
      createElement(
        "div",
        { style: { marginBottom: "1em" } },
        // Custom styled label
        createElement(
          "label",
          {
            style: {
              fontSize: "22px", // ✅ Custom font size
              fontWeight: "bold",
              display: "block",
              marginBottom: "8px",
            },
          },
          "Tangible Uploads"
        ),
        // Unlabeled SelectControl
        createElement(SelectControl, {
          value: attributes.selectedFile,
          options: files,
          onChange: (value) => {
            setAttributes({ selectedFile: value });
          },
        })
      ),

      attributes.selectedFile
        ? createElement("iframe", {
            src: attributes.selectedFile,
            style: {
              width: "100%",
              height: "300px",
              border: "1px solid #ccc",
              marginTop: "10px",
            },
          })
        : null
    );
  },

  save({ attributes }) {
    return attributes.selectedFile
      ? createElement("iframe", {
          src: attributes.selectedFile,
          style: { width: "100%", height: "300px", border: "1px solid #ccc" },
        })
      : null;
  },
});
