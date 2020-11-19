// Follow along https://stampede-design.com/blog/creating-a-custom-block-type-for-wordpress-gutenberg-editor/ or
// https://deliciousbrains.com/custom-gutenberg-block/ for some idea of how to do this.


/* This section of the code registers a new block, sets an icon and a category, and indicates what type of fields it'll include. */

wp.blocks.registerBlockType('modsnap/cards-grid', {
    title: 'Modsnap Cards',
    icon: 'grid-view',
    category: 'common',
    attributes: {
        content: { type: 'string' },
        color: { type: 'string' },
        boxStuff: { type: 'array' }
    },

    /* This configures how the content and color fields will work, and sets up the necessary elements */

    edit: function (props) {
        function updateContent(event) {
            props.setAttributes({ content: event.target.value })
        }
        function updateSelect(event) {
            props.setAttributes({ boxStuff: event.target.value })
        }
        function updateColor(value) {
            props.setAttributes({ color: value.hex })
        }
        return React.createElement(
            "div",
            null,
            React.createElement(
                "h3",
                null,
                "Simple Box"
            ),
            React.createElement("input", { type: "text", value: props.attributes.content, onChange: updateContent }),
            React.createElement("input", { type: "checkbox", value: "cat1", name: "category1", id: "category1", onChange: updateSelect }),
            React.createElement("label", { for: "category1" }),
            React.createElement("input", { type: "checkbox", value: "cat2", name: "category2", id: "category1", onChange: updateSelect }),
            React.createElement("label", { for: "category2" }),
            React.createElement("input", { type: "checkbox", value: "cat3", name: "category3", id: "category1", onChange: updateSelect }),
            React.createElement("label", { for: "category3" }),
            React.createElement(wp.components.ColorPicker, { color: props.attributes.color, onChangeComplete: updateColor })
        );
    },
    save: function (props) {
        return wp.element.createElement(
            "h3",
            { style: { border: "3px solid " + props.attributes.color } },
            props.attributes.content
        );
    }
})