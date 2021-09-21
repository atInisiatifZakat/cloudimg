import PropTypes from 'prop-types';
import { Fragment } from 'react';

function ContentWrapper(props) {
  return <Fragment>{props.children}</Fragment>;
}

ContentWrapper.propTypes = {
  children: PropTypes.any
};

export default ContentWrapper;
