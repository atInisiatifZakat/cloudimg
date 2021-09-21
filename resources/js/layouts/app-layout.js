import { chakra, Flex, VStack } from '@chakra-ui/react';
import { AuthProvider } from '../contexts/auth';
import TopBar from '../components/navbar/top-bar';
import ContentWrapper from '../components/common/content-wrapper';
import PropTypes from 'prop-types';
import { Helmet } from 'react-helmet';

function AppLayout({ children, title }) {
  return (
    <AuthProvider>
      <Helmet>
        <title>{title ? `${title} - CloudImg` : 'CloudImg'}</title>
      </Helmet>
      <VStack minH="100vh" bg="gray.50">
        <TopBar />
        <Flex
          justifyItems="center"
          alignItems="center"
          justifyContent="center"
          w="full"
        >
          <chakra.div my={{ base: 2, md: 4 }}>
            <ContentWrapper>{children}</ContentWrapper>
          </chakra.div>
        </Flex>
      </VStack>
    </AuthProvider>
  );
}

AppLayout.propTypes = {
  children: PropTypes.any,
  title: PropTypes.string
};

export default AppLayout;
