console.log('I am loaded');
wp.blocks.registerBlockStyle( 'core/quote', {
    name: 'fancy-quote',
    label: 'Fancy Quote',
    
} );

// wp.blocks.unregisterBlockStyle( 'core/quote', 'fancy-quote' );

wp.domReady(function() {
    wp.blocks.unregisterBlockStyle( 'core/quote', 'large' );
});