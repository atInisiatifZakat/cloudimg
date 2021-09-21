import { VStack } from '@chakra-ui/react';

import AppLayout from '../layouts/app-layout';
import CreateFrom from '../components/source/create-form';
import { Card, CardContent } from '../components/card';

const Home = () => {
  return (
    <AppLayout title="Home">
      <VStack w={{ base: 'full', md: '5xl' }} px={{ base: 2, md: 4 }}>
        <Card>
          <CardContent>
            <CreateFrom />
          </CardContent>
        </Card>
      </VStack>
    </AppLayout>
  );
};

export default Home;
