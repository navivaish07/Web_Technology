function EventCard({ event, onView, onRegister }) {
  return (
    <article className="event-card">
      <img src={event.image} alt={event.name} className="event-image" />

      <div className="event-card-content">
        <h3>{event.name}</h3>
        <p className="event-date">{event.date}</p>
        <p className="event-fee">Entry Fee: Rs. {event.fee}</p>

        <div className="event-card-actions">
          <button className="btn btn-secondary" onClick={() => onView(event)}>
            View Details
          </button>
          <button className="btn" onClick={() => onRegister(event)}>
            Register
          </button>
        </div>
      </div>
    </article>
  );
}

export default EventCard;
