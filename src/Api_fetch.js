import React, { useState, useEffect } from "react";
import { useNavigate, Link } from "react-router-dom";


const Home = () => {
  const [post, setPost] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    fetch("http://localhost:8080/wordpress/api%20fetch/custom/real.php")
      .then((res) => {
        if (!res.ok) {
          throw new Error("Network response was not ok");
        }
        return res.json();
      })
      .then((response) => {
        console.log("Data received:", response);
        setPost(response.data); // Assuming the response is an object with a 'data' property
      })
      .catch((err) => {
        console.error("Error fetching data:", err);
        setError(err);
      })
      .finally(() => setLoading(false));
  }, []);

  const navigate = useNavigate();

  return (
    <>
      {loading ? (
        <p>Loading...</p>
      ) : error ? (
        <p>Error: {error.message}</p>
      ) : (
        <>
          {post.map((user) => (
            <li key={user.id}>
              <h4>{user.name}</h4>
              <p>{user.email}</p>
              <p>{user.message}</p>
              {/* <p>{user.image}</p> */}
              {/* Use Link to navigate to details page */}
              <Link to={`/param/${user.id}`}>
                <button>View Details</button>
              </Link>
            </li>
          ))}
        </>
      )}
    </>
  );
};

export default Home;
