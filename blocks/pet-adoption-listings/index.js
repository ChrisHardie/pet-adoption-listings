( function( wp ) {
	/**
	 * Registers a new block provided a unique name and an object defining its behavior.
	 * @see https://github.com/WordPress/gutenberg/tree/master/blocks#api
	 */
	var registerBlockType = wp.blocks.registerBlockType;
	/**
	 * Returns a new element of given type. Element is an abstraction layer atop React.
	 * @see https://github.com/WordPress/gutenberg/tree/master/element#element
	 */
	var el = wp.element.createElement,
        ServerSideRender = wp.components.ServerSideRender,
        TextControl = wp.components.TextControl,
        InspectorControls = wp.editor.InspectorControls;

	/**
	 * Retrieves the translation of text.
	 * @see https://github.com/WordPress/gutenberg/tree/master/i18n#api
	 */
	var __ = wp.i18n.__;

	/**
	 * Every block starts by registering a new block type definition.
	 * @see https://wordpress.org/gutenberg/handbook/block-api/
	 */
	registerBlockType( 'pet-adoption-listings/pet-adoption-listings', {
		/**
		 * This is the display title for your block, which can be translated with `i18n` functions.
		 * The block inserter will show this name.
		 */
		title: __( 'Pet adoption listings' ),

		/**
		 * Blocks are grouped into categories to help users browse and discover them.
		 * The categories provided by core are `common`, `embed`, `formatting`, `layout` and `widgets`.
		 */
		category: 'widgets',

		/**
		 * Optional block extended support features.
		 */
		supports: {
			// Removes support for an HTML mode.
			html: false,
		},

		/**
		 * The edit function describes the structure of your block in the context of the editor.
		 * This represents what the editor will render when the block is used.
		 * @see https://wordpress.org/gutenberg/handbook/block-edit-save/#edit
		 *
		 * @param {Object} [props] Properties passed from the editor.
		 * @return {Element}       Element to render.
		 */
		edit: function( props ) {
            return [
                /*
                 * The ServerSideRender element uses the REST API to automatically call
                 * php_block_render() in your PHP code whenever it needs to get an updated
                 * view of the block.
                 */
                el( ServerSideRender, {
                    block: 'pet-adoption-listings/pet-adoption-listings',
                    attributes: props.attributes,
                } ),
                /*
                 * InspectorControls lets you add controls to the Block sidebar. In this case,
                 * we're adding a TextControl, which lets us edit the 'foo' attribute (which
                 * we defined in the PHP). The onChange property is a little bit of magic to tell
                 * the block editor to update the value of our 'foo' property, and to re-render
                 * the block.
                 */
                el( InspectorControls, {},
                    el( TextControl, {
                        label: 'Shelter ID',
                        value: props.attributes.shelter_id,
                        onChange: ( value ) => { props.setAttributes( { shelter_id: value } ); },
                    } )
                ),
            ];
		},

		/**
		 * The save function defines the way in which the different attributes should be combined
		 * into the final markup, which is then serialized by Gutenberg into `post_content`.
		 * @see https://wordpress.org/gutenberg/handbook/block-edit-save/#save
		 *
		 * @return {Element}       Element to render.
		 */
		save: function() {
            return null;
		}
	} );
} )(
	window.wp
);
