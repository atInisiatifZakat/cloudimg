import { Box } from '@chakra-ui/react';
import PropTypes from 'prop-types';

function CardMenu({ children, ...rest }) {
  return <Box {...rest}>{children}</Box>;
}

CardMenu.propTypes = {
  children: PropTypes.any
};

export default CardMenu;
