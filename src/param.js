import React, { useState, useEffect } from 'react';
import { useParams, Link } from 'react-router-dom';

const Param = ({ onAddToCart }) => {
  const { id } = useParams();
  const [details, setDetails] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch(`http://localhost:8080/wordpress/api%20fetch/custom/real.php?id=${id}`);
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        const data = await response.json();
        setDetails(data);
      } catch (err) {
        console.error('Error fetching data:', err);
        setError(err);
      } finally {
        setLoading(false);
      }
    };

    fetchData();
  }, [id]);

  const handleAddToCart = () => {
    onAddToCart(details.data); // Pass details.data to onAddToCart prop
    console.log('Added to Cart:', details.data);
  };

  return (
    <div>
      <h2>Details for Item with ID: {id}</h2>
      <p>Name: {details?.data?.name}</p>
      <p>Email: {details?.data?.email}</p>
      <p>Message: {details?.data?.message}</p>
      <button onClick={handleAddToCart}>Add to Cart</button>
      <Link to="/cart">
        <div style={{ display: 'flex', alignItems: 'center' }}>
          <span role="img" aria-label="cart">🛒</span>
          <p style={{ marginLeft: '5px' }}>Cart ({onAddToCart.length})</p>
        </div>
      </Link>
    </div>
  );
};

export default Param;
