import PropTypes from 'prop-types';
import { Box } from '@chakra-ui/react';

function CardFooter({ children, ...rest }) {
  return (
    <Box
      w="full"
      px={{ base: 2, md: 4 }}
      py={{ base: 1, md: 2 }}
      bg="gray.200"
      {...rest}
    >
      {children}
    </Box>
  );
}

CardFooter.propTypes = {
  children: PropTypes.any
};

export default CardFooter;
