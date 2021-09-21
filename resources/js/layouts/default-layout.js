import PropTypes from 'prop-types';
import { VStack } from '@chakra-ui/react';

function DefaultLayout({ children }) {
  return (
    <VStack minH="100vh" w="full">
      {children}
    </VStack>
  );
}

DefaultLayout.propTypes = {
  children: PropTypes.any
};

export default DefaultLayout;
