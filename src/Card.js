import React from "react";
const Card = ({ user }) => {
  return (
    <div key={user.id}>
      <h4>{user.title}</h4>
      <p>{user.body}</p>
    </div>
  );
};
export default Card;

