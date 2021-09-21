import PropTypes from 'prop-types';
import { Stack } from '@chakra-ui/react';

function Card({ children, ...rest }) {
  return (
    <Stack
      bg="white"
      w="full"
      shadow="base"
      rounded={[null, 'sm']}
      spacing={2}
      direction="column"
      {...rest}
    >
      {children}
    </Stack>
  );
}

Card.propTypes = {
  children: PropTypes.any
};

export default Card;
