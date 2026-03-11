import { useMemo, useState } from "react";

function Clubs({ clubs }) {
  const clubNames = useMemo(() => Object.keys(clubs), [clubs]);
  const [selectedClub, setSelectedClub] = useState(clubNames[0]);
  const club = clubs[selectedClub];

  return (
    <div>
      <h2 className="section-title">Explore Club Activities</h2>

      <div className="club-list">
        {clubNames.map((club) => (
          <button
            key={club}
            className={`club-item ${selectedClub === club ? "active" : ""}`}
            onClick={() => setSelectedClub(club)}
          >
            {club}
          </button>
        ))}
      </div>

      {selectedClub && (
        <article className="club-details">
          <img
            src={club.image}
            alt={selectedClub}
            className="club-image"
          />

          <div className="club-copy">
            <div className="club-header">
              <h3>{selectedClub}</h3>
              <p className="club-tag">Student-Led Community</p>
            </div>

            <p>{club.desc}</p>

            <div className="club-meta">
              <span>Lead: {club.lead}</span>
              <span>When: {club.schedule}</span>
              <span>Where: {club.venue}</span>
              <span>{club.members}</span>
            </div>

            <div className="club-panels">
              <section className="club-panel">
                <h4>Focus Areas</h4>
                <ul>
                  {club.focusAreas.map((item) => (
                    <li key={item}>{item}</li>
                  ))}
                </ul>
              </section>
              <section className="club-panel">
                <h4>Recent Achievements</h4>
                <ul>
                  {club.achievements.map((item) => (
                    <li key={item}>{item}</li>
                  ))}
                </ul>
              </section>
            </div>

            <p className="club-upcoming">Upcoming: {club.upcoming}</p>
            <p className="club-contact">Contact: {club.contact}</p>
          </div>
        </article>
      )}
    </div>
  );
}

export default Clubs;
