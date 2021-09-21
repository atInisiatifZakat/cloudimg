import PropTypes from 'prop-types';
import { Box } from '@chakra-ui/react';

function CardContent({ children, ...rest }) {
  return (
    <Box w="full" px={{ base: 2, md: 4 }} py={{ base: 1, md: 2 }} {...rest}>
      {children}
    </Box>
  );
}

CardContent.propTypes = {
  children: PropTypes.any
};

export default CardContent;
