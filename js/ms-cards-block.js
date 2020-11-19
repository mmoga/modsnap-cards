// https://awhitepixel.com/blog/wordpress-gutenberg-create-custom-block-tutorial/

const { registerBlockType } = wp.blocks;

registerBlockType('modsnap/cards-grid', {
  title: 'Modsnap Cards',
  icon: 'grid-view',
  category: 'common',
  description: 'Add a card grid by category.',
  keywords: ['grid', 'card'],

  edit() {
    return (
      <div>
        <div>:)</div>;
      </div>
    );
  },
  save() {
    return `<div>:)</div>`;
  },
});
