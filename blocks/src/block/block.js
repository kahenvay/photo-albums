/**
 * BLOCK: main
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import './style.scss';
import './editor.scss';

import { AlbumSelect } from './components/AlbumSelect';
import { AlbumPreview } from './components/AlbumPreview';

const {__} = wp.i18n; // Import __() from wp.i18n
const {registerBlockType, InspectorControls} = wp.blocks; // Import registerBlockType() from wp.blocks
const {apiRequest} = wp;

/**
 * Register: aa Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */

registerBlockType('tdy-pa/main', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __('Tredny Photo Albums'), // Block title.
	icon: 'shield', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__('Tredny Photo Albums'),
		__('Tredny Image Gallery'),
	],
	attributes: {
		selectedAlbumId: {
		},
		selectedAlbumTitle: {
		}
	},

	/**
	 * The edit function describes the structure of your block in the context of the editor.
	 * This represents what the editor will render when the block is used.
	 *
	 * The "edit" property must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 */
	edit: function(props) {
		// Creates a <p class='wp-block-cgb-main'></p>.

		const {attributes: {selectedAlbumId, selectedAlbumTitle}, setAttributes} = props;

		// const promiseOptions = inputValue => new Promise(resolve => {
		// 	resolve(api.getAlbums()
		// 		.then(response => {

		// 			return response.data.map(post => {

		// 				console.log('post', post);

		// 				return {
		// 					value: post.id.toString(),
		// 					label: post.title.rendered
		// 				}
		// 			})
		// 		}));

		// });


		// // let handleSelectChange = (selectedAlbumId) => {
		// // 	setAttributes({
		// // 		selectedAlbumId
		// // 	});
		// // 	console.log(`Option selected:`, selectedAlbumId);
		// // }

		// let handleInputChange = (input) => {
		// 	const promiseOptions = () => new Promise(resolve => {
		// 		resolve(api.searchAlbums(input)
		// 			.then(response => {

		// 				return response.data.map(post => {

		// 					console.log('post', post);

		// 					return {
		// 						value: post.id.toString(),
		// 						label: post.title.rendered
		// 					}
		// 				})
		// 			}));

		// 	});
		// };

		let changeSelectedAlbum = (selectedAlbumId, selectedAlbumTitle) => {
			setAttributes({
				selectedAlbumId,
				selectedAlbumTitle
			});

			console.log('selectedAlbumId', selectedAlbumId);
			console.log('selectedAlbumTitle', selectedAlbumTitle);

		}

		return (

			<div className={ props.className }>
     <div> Photo Albums </div>
     <div> Select an album you wish to show, a preview will be shown</div>
     <AlbumSelect changeSelectedAlbum={ changeSelectedAlbum } selectedAlbumId={ selectedAlbumId } selectedAlbumTitle={ selectedAlbumTitle } />
     { selectedAlbumId ? (
       <AlbumPreview selectedAlbumId={ selectedAlbumId } />
       ) : (
       <div> Preview to be shown once an album has been selected </div>
       ) }
   </div>
			);
	},

	// <AsyncSelect value={ selectedAlbumId } matchPos="start" matchProp="any" onFocus={ promiseOptions } loadOptions={ promiseOptions } onChange={ handleSelectChange }
	///>
	// <InputLookup />
	// <PostSelector />

	// edit: editContactForm,

	/**
	 * The save function defines the way in which the different attributes should be combined
	 * into the final markup, which is then serialized by Gutenberg into post_content.
	 *
	 * The "save" property must be specified and must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 */
	save: function(props) {
		const {attributes: {selectedAlbumId, selectedAlbumTitle}, setAttributes} = props;
		return null;
	},
});
