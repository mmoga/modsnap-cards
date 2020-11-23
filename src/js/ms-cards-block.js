/* eslint-disable react/display-name */
// https://awhitepixel.com/blog/wordpress-gutenberg-create-custom-block-tutorial/

const { registerBlockType } = wp.blocks;
const { RichText } = wp.blockEditor;

registerBlockType('modsnap/cards-grid', {
  title: 'Modsnap Cards',
  icon: 'grid-view',
  category: 'common',
  description: 'Add a card grid by category.',
  keywords: ['grid', 'card'],
  attributes: {
    myRichHeading: {
      type: 'string',
    },
    myRichText: {
      type: 'string',
      source: 'html',
      selector: 'p',
    },
  },
  edit: (props) => {
    const { attributes, setAttributes } = props;
    return (
      <div>
        <RichText
          tagName="h2"
          placeholder="Write your heading here"
          value={attributes.myRichHeading}
          onChange={(newtext) => setAttributes({ myRichHeading: newtext })}
        />
        <RichText
          tagName="p"
          placeholder="Write your paragraph here"
          value={attributes.myRichText}
          onChange={(newtext) => setAttributes({ myRichText: newtext })}
        />
      </div>
    );
  },
  save: (props) => {
    const { attributes } = props;
    return (
      <div>
        <RichText.Content tagName="h2" value={attributes.myRichHeading} />
        <RichText.Content tagName="p" value={attributes.myRichText} />
      </div>
    );
  },
});
