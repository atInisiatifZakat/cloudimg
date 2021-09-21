import { CircularProgress, Flex, Image, VStack } from '@chakra-ui/react';
import Logo from '../../assets/images/logo.svg';

export default function Spinner() {
  return (
    <Flex h="100vh" justifyContent="center" alignItems="center" bg="white">
      <Flex direction="column">
        <VStack spacing={4} padding={8}>
          <Image src={Logo} mb={6} htmlWidth="125" />
          <CircularProgress isIndeterminate color="blue.500" />
        </VStack>
      </Flex>
    </Flex>
  );
}
