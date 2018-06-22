import React from 'react';
import cx from 'classnames';

class HotKeyOption extends React.Component {


	constructor (props) {
		super(props);
		this.selectOption = this.selectOption.bind(this);
		this.handleKeyup = this.handleKeyup.bind(this);
	}


	componentDidMount () {
		document.addEventListener('keyup', this.handleKeyup);
	}


	componentWillUnmount () {
		document.removeEventListener('keyup', this.handleKeyup);
	}


	handleKeyup (e) {
		const {tagName} = e.target;

		if(tagName !== 'TEXTAREA' && tagName !== 'INPUT') {
			if(this.props.keyCodes.indexOf(e.keyCode) !== -1) {
				this.selectOption();
			}			
		}
	}
	selectOption () {
		const { onSelected, eventKey, disabled } = this.props;

		if (!disabled) {
            onSelected && onSelected(eventKey);
		}
	}


	render () {
		let classes = [
			this.props.className,
			this.props.selected ? 'current-vote' : '',
			this.props.disabled ? 'disabled' : ''
		].join(' ');

		return React.createElement(
			this.props.component,
			{...this.props, className: classes},			
			<a href="javascript:void(0);" onClick={this.selectOption}>
				{this.props.children}
				<div className="voting-shortcut">{this.props.eventKey}</div>
			</a>
		);
	}
}

HotKeyOption.propTypes = {
	eventKey: React.PropTypes.any.isRequired,
	keyCodes: React.PropTypes.array,
	onSelected: React.PropTypes.func,
	selected: React.PropTypes.bool,
	component: React.PropTypes.string
};

HotKeyOption.defaultProps = {
	component: 'li'
};

export default HotKeyOption;