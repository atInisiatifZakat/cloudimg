import { Heading } from '@chakra-ui/react';
import PropTypes from 'prop-types';

function CardTitle({ title }) {
  return (
    <Heading as="h4" size="md" fontWeight="medium">
      {title}
    </Heading>
  );
}

CardTitle.propTypes = {
  title: PropTypes.any
};

export default CardTitle;
