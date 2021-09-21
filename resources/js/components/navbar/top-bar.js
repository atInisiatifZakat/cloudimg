import PropTypes from 'prop-types';
import {
  Box,
  Button,
  chakra,
  CloseButton,
  Flex,
  HStack,
  IconButton,
  useColorModeValue,
  useDisclosure,
  VStack
} from '@chakra-ui/react';
import ProfileMenu from './profile-menu';
import TopBarLogo from './top-bar-logo';
import { AiOutlineMenu } from 'react-icons/ai';
import { Link } from '@inertiajs/inertia-react';

function MenuItem({ menu, ...rest }) {
  return (
    <Button
      {...rest}
      key={menu.link}
      w="full"
      as={Link}
      href={menu.link}
      variant="ghost"
      leftIcon={menu.icon}
    >
      {menu.name}
    </Button>
  );
}

MenuItem.propTypes = {
  menu: PropTypes.shape({
    name: PropTypes.string,
    link: PropTypes.string,
    icon: PropTypes.element
  })
};

function TopBarMobileMenu({ menuItems }) {
  const bg = useColorModeValue('white', 'gray.800');
  const mobileNav = useDisclosure();

  return (
    <Box display={{ base: 'inline-flex', md: 'none' }}>
      <IconButton
        display={{ base: 'flex', md: 'none' }}
        aria-label="Open menu"
        fontSize="20px"
        color={useColorModeValue('gray.800', 'inherit')}
        variant="ghost"
        icon={<AiOutlineMenu />}
        onClick={mobileNav.onOpen}
      />
      <VStack
        pos="absolute"
        top={0}
        left={0}
        right={0}
        display={mobileNav.isOpen ? 'flex' : 'none'}
        flexDirection="column"
        p={2}
        pb={4}
        m={2}
        bg={bg}
        spacing={3}
        rounded="sm"
        shadow="sm"
      >
        <CloseButton
          aria-label="Close menu"
          justifySelf="self-start"
          onClick={mobileNav.onClose}
        />
        {menuItems.map((item) => (
          <MenuItem menu={item} key={item.link} />
        ))}
      </VStack>
    </Box>
  );
}

TopBarMobileMenu.defaultProps = {
  menuItems: []
};

TopBarMobileMenu.propTypes = {
  menuItems: PropTypes.arrayOf(
    PropTypes.shape({
      name: PropTypes.string,
      link: PropTypes.string,
      icon: PropTypes.element,
      permission: PropTypes.string
    })
  )
};

function TopBarDesktopMenu({ menuItems }) {
  return (
    <HStack spacing={3} display={{ base: 'none', md: 'inline-flex' }}>
      {menuItems.map((item) => (
        <MenuItem menu={item} key={item.link} size="sm" />
      ))}
    </HStack>
  );
}

TopBarDesktopMenu.defaultProps = {
  menuItems: []
};

TopBarDesktopMenu.propTypes = {
  menuItems: PropTypes.arrayOf(
    PropTypes.shape({
      name: PropTypes.string,
      link: PropTypes.string,
      icon: PropTypes.element,
      permission: PropTypes.string
    })
  )
};

function TopBar({ menuItems }) {
  const mobileNav = useDisclosure();
  const bg = useColorModeValue('white', 'gray.800');

  return (
    <chakra.header bg={bg} w="full" px={{ base: 2, sm: 4 }} py={2} shadow="md">
      <Flex alignItems="center" justifyContent="space-between" mx="auto">
        <HStack display="flex" spacing={3} alignItems="center">
          <TopBarLogo />
          <TopBarDesktopMenu menuItems={menuItems} />
        </HStack>
        <HStack spacing={3} display={mobileNav.isOpen ? 'none' : 'flex'}>
          <ProfileMenu />
        </HStack>
      </Flex>
    </chakra.header>
  );
}

TopBar.defaultProps = {
  menuItems: []
};

TopBar.propTypes = {
  menuItems: PropTypes.arrayOf(
    PropTypes.shape({
      name: PropTypes.string,
      link: PropTypes.string,
      icon: PropTypes.element,
      permission: PropTypes.string
    })
  )
};

export default TopBar;
