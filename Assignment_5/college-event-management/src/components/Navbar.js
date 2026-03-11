function Navbar() {
  return (
    <nav className="navbar">
      <div className="logo">
        <span>College Event Hub</span>
      </div>

      <div className="nav-links">
        <a href="#events">Events</a>
        <a href="#clubs">Clubs</a>
        <a href="#register">Register</a>
      </div>
    </nav>
  );
}

export default Navbar;
