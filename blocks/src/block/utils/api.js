import axios from 'axios';

export const getAlbums = () => axios.get('/wp-json/wp/v2/tdy_photo_album');

export const getAlbumByID = (id) => axios.get(`/wp-json/wp/v2/tdy_photo_album/${id}`);

//by title
export const searchAlbums = (input) => {
	return axios.get(`/wp-json/wp/v2/tdy_photo_album?search=${input}`);
};

