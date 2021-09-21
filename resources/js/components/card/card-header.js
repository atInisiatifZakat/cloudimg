import PropTypes from 'prop-types';
import { HStack } from '@chakra-ui/react';

function CardHeader({ children, ...rest }) {
  return (
    <HStack
      justifyItems="center"
      justifyContent="space-between"
      w="full"
      px={{ base: 2, md: 4 }}
      py={{ base: 1, md: 2 }}
      {...rest}
    >
      {children}
    </HStack>
  );
}

CardHeader.propTypes = {
  children: PropTypes.any
};

export default CardHeader;
