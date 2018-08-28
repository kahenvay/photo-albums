const {Component} = wp.element;
import * as api from '../utils/api';
import AsyncSelect from 'react-select/lib/Async';

const promiseOptions = inputValue => new Promise(resolve => {

	resolve(api.searchAlbums(inputValue)
		.then(response => {

			return response.data.map(post => {

				return {
					value: post.id.toString(),
					label: post.title.rendered + ', ' + post.location + ', ' + post.date
				}
			})
		}));

});

var options = promiseOptions(' ');

export class AlbumSelect extends Component {

	constructor(props) {
		super(...arguments);
		this.props = props;
		this.state = {
			inputValue: ' '
		}

		this.myHandleInputChange = this.myHandleInputChange.bind(this);
		this.handleSelection = this.handleSelection.bind(this);

	}

	componentDidMount() {


		if (this.props.selectedAlbumId && this.props.selectedAlbumTitle) {
			this.setState({
				defaultOption: {
					value: this.props.selectedAlbumId,
					label: this.props.selectedAlbumTitle
				}
			}, () => {
				console.log('Album select did moint state :', this.state);
			});
		}



	}

	myHandleInputChange(newValue) {

		const inputValue = newValue;
		this.setState({
			inputValue
		});
		console.log('inputValue', inputValue);

		return inputValue;
	}

	handleSelection(selectedOption) {
		this.props.changeSelectedAlbum(selectedOption.value, selectedOption.label);
	}



	render() {
		return (
			<div className="AlbumSelect">
     <AsyncSelect noOptionsMessage={ ({inputValue}) => !inputValue && 'Type to search (space for the last 10 posted)' } autoFocus="false" matchPos="start" matchProp="any" onClick={ promiseOptions } loadOptions={ promiseOptions }
       onInputChange={ this.myHandleInputChange } onChange={ this.handleSelection } defaultOptions={ this.state.defaultOption } />
   </div>
			);
	}
}

// selectedValue={ this.props.selectedAlbumTitle }