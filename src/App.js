import React, { useState } from "react";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import Home from "./Api_fetch";
import Param from "./param";
import Cart from "./Cart";

const App = () => {
  const [cartItems, setCartItems] = useState([]);

  const handleAddToCart = (item) => {
    setCartItems((prevItems) => [...prevItems, item]);
  };

  const handleRemoveFromCart = (itemId) => {
    setCartItems((prevItems) => prevItems.filter((item) => item.id !== itemId));
  };

  return (
    <Router>
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/param/:id" element={<Param onAddToCart={handleAddToCart} />} />
        <Route path="/cart" element={<Cart cartItems={cartItems} removeItem={handleRemoveFromCart} />} />
      </Routes>
    </Router>
  );
};

export default App;
