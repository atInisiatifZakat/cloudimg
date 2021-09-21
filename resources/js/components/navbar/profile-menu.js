import {
  Avatar,
  Icon,
  Menu,
  MenuButton,
  MenuDivider,
  MenuItem,
  MenuList
} from '@chakra-ui/react';
import { FaCog, FaSignOutAlt } from 'react-icons/fa';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';

import { useAuth } from '../../contexts/auth';
import { cancelToken, http } from '../../utils/http';

export default function ProfileMenu() {
  const auth = useAuth();

  const handleLogout = () => {
    http
      .get('/auth/logout', {
        cancelToken: cancelToken.token
      })
      .then(() => {
        Inertia.visit('/auth/login', { replace: true });
      });
  };

  return (
    <Menu>
      <Avatar as={MenuButton} name={auth.user.name} />
      <MenuList>
        <MenuItem as={Link} href="/settings" icon={<Icon as={FaCog} />}>
          Settings
        </MenuItem>
        <MenuDivider />
        <MenuItem onClick={handleLogout} icon={<Icon as={FaSignOutAlt} />}>
          Sign out
        </MenuItem>
      </MenuList>
    </Menu>
  );
}
