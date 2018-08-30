const {Component} = wp.element;
import * as api from '../utils/api';
import { AlbumOutput } from './AlbumOutput';

export class AlbumPreview extends Component {

	constructor(props) {
		super(...arguments);
		this.props = props;
		this.state = {
			title: '',
			location: '',
			date: '',
			photos: []
		}

		this.getAlbum = this.getAlbum.bind(this);

	}

	getAlbum() {
		if (this.props.selectedAlbumId) {
			api.getAlbumByID(this.props.selectedAlbumId)
				.then((response) => {
					console.log('getAlbum response', response);

					var {title, location, date, photos} = response.data;

					title = title.rendered;
					photos = JSON.parse(photos);

					this.setState({
						title,
						location,
						date,
						photos
					}, () => {
						console.log('preview state after get:', this.state);
					});

				})
		}

	}

	componentDidMount() {
		this.getAlbum();
	}

	componentDidUpdate() {
		// this.getAlbum();
	}

	render() {
		return (
			<div className="AlbumPreview tdy_photo_album
      tdy_photo_gallery">
     <div class="album">
       { this.state.photos.map((photo) => {
         	return (
         		<AlbumOutput photoSrc={ photo.src } />
         		);
         }) }
     </div>
   </div>
		)
	}
}

