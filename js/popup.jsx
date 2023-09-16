import React, { useState } from 'react';
import axios from 'axios';

function App() {
  const [notification, setNotification] = useState('');

  const confirmDelete = async (id) => {
    const confirmation = window.confirm("Apakah Anda yakin ingin menghapus data administrator ini?");
    if (confirmation) {
      try {
        const response = await axios.post('deleteUser.php', { id });
        if (response.data.success) {
          setNotification('Data administrator berhasil dihapus.');
          // Update your user list or perform necessary actions
        } else {
          setNotification('Terjadi kesalahan saat menghapus data.');
        }
      } catch (error) {
        setNotification('Terjadi kesalahan: ' + error.message);
      }
    }
  };

  return (
    <div>
      {/* Render user list and other components */}
      {notification && <div className="notification">{notification}</div>}
    </div>
  );
}

export default App;
