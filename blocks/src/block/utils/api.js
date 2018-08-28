import axios from 'axios';

// export const getPostTypes = () => axios.get('/wp-json/wp/v2/types');

// export const getPosts = ({restBase = false}, ...args) => {
// 	const queryString = Object.keys(args).map(arg => `${arg}=${args[arg]}`).join('&');
// 	return axios.get(`/wp-json/wp/v2/${restBase}?${queryString}&_embed`);
// };

export const getAlbums = () => axios.get('/wp-json/wp/v2/tdy_photo_album');

export const getAlbumByID = (id) => axios.get(`/wp-json/wp/v2/tdy_photo_album/${id}`);

//by title
export const searchAlbums = (input) => {
	return axios.get(`/wp-json/wp/v2/tdy_photo_album?search=${input}`);
};

