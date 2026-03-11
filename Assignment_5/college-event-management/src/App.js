import React, { useState } from "react";
import Navbar from "./components/Navbar";
import EventCard from "./components/EventCard";
import EventDetails from "./components/EventDetails";
import Clubs from "./components/Clubs";
import RegisterForm from "./components/RegisterForm";
import "./App.css";

function App() {
  const events = [
    {
      name: "Sanjivani Techfest",
      date: "24 March 2026",
      description: "Technical fest with coding competitions and project exhibitions.",
      fee: 200,
      time: "10:00 AM - 5:00 PM",
      venue: "Main Auditorium",
      seats: 250,
      organizer: "Computer Department",
      coordinator: "Prof. A. Patil",
      highlights: ["Hackathon finals", "Project expo", "Expert talks"],
      agenda: ["Inauguration", "Coding rounds", "Prize distribution"],
      image:
        "https://images.unsplash.com/photo-1523580494863-6f3031224c94?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8dGVjaCUyMGV2ZW50fGVufDB8fDB8fHww"
    },
    {
      name: "AWS Community Day",
      date: "28 March 2026",
      description: "Cloud computing workshop conducted by AWS experts.",
      fee: 150,
      time: "11:00 AM - 3:00 PM",
      venue: "Seminar Hall",
      seats: 180,
      organizer: "Cloud Club",
      coordinator: "Prof. S. Kulkarni",
      highlights: ["Hands-on labs", "AWS speaker sessions", "Certification guidance"],
      agenda: ["Welcome note", "Workshop sessions", "Q&A and networking"],
      image: "https://images.unsplash.com/photo-1451187580459-43490279c0fa"
    },
    {
      name: "Robotics Club Activity",
      date: "20 April 2026",
      description: "Hands-on robotics building session.",
      fee: 100,
      time: "9:30 AM - 1:30 PM",
      venue: "Robotics Lab",
      seats: 120,
      organizer: "Robotics Club",
      coordinator: "Prof. R. Joshi",
      highlights: ["Line follower bot", "Sensor integration", "Mini challenge"],
      agenda: ["Intro to hardware", "Team build", "Demo and feedback"],
      image: "https://images.unsplash.com/photo-1581092335397-9583eb92d232"
    }
  ];

  const clubs = {
    "Coding Club": {
      desc: "Build production-ready software through contests, pair-programming labs, and campus hack sprints.",
      image: "https://images.unsplash.com/photo-1517694712202-14dd9538aa97",
      lead: "Prof. N. Deshmukh",
      schedule: "Every Wednesday, 5:00 PM",
      venue: "Innovation Lab 2",
      members: "140+ active members",
      contact: "codingclub@sanjivani.edu",
      upcoming: "Open Source Contribution Drive - 26 March 2026",
      focusAreas: ["DSA and interview prep", "Full-stack web projects", "Open-source contributions"],
      achievements: ["3 Smart India Hackathon finalists", "15+ internship offers in 2025", "Hosted a 24-hour campus hackathon"]
    },
    "Robotics Club": {
      desc: "Design and prototype intelligent robots with practical exposure to sensors, controls, and embedded systems.",
      image: "https://images.unsplash.com/photo-1562408590-e32931084e23",
      lead: "Prof. R. Joshi",
      schedule: "Saturday, 10:00 AM",
      venue: "Mechatronics Workshop",
      members: "95+ active members",
      contact: "robotics@sanjivani.edu",
      upcoming: "Inter-College Robo Race - 20 April 2026",
      focusAreas: ["Arduino and Raspberry Pi", "Autonomous navigation", "IoT-enabled robots"],
      achievements: ["1st place at RoboWar 2025", "4 patent filings by members", "Built 12 line-follower robots"]
    },
    "AI & ML Club": {
      desc: "Apply AI to real campus and community problems through guided projects, model labs, and research circles.",
      image: "https://images.unsplash.com/photo-1555949963-aa79dcee981c",
      lead: "Dr. K. Patwardhan",
      schedule: "Friday, 4:30 PM",
      venue: "Data Science Studio",
      members: "120+ active members",
      contact: "aimlclub@sanjivani.edu",
      upcoming: "Campus Data Challenge - 3 April 2026",
      focusAreas: ["Python for AI", "Computer vision", "NLP and chatbot systems"],
      achievements: ["Published 6 student papers", "2 national-level AI challenge winners", "Deployed college feedback analyzer"]
    },
    "Entrepreneurship Club": {
      desc: "Transform ideas into ventures with startup bootcamps, founder sessions, and product validation workshops.",
      image: "https://images.unsplash.com/photo-1556761175-4b46a572b786",
      lead: "Prof. M. Shinde",
      schedule: "Monday, 6:00 PM",
      venue: "Startup Incubation Cell",
      members: "80+ active members",
      contact: "ecell@sanjivani.edu",
      upcoming: "Pitch Deck Demo Day - 8 April 2026",
      focusAreas: ["Business model design", "Product-market fit", "Fundraising basics"],
      achievements: ["5 startups incubated in-house", "2 funded student ventures", "Monthly mentor network with founders"]
    },
    "Cultural Club": {
      desc: "Celebrate campus diversity through curated performances, festival management, and creative arts collaborations.",
      image: "https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad",
      lead: "Prof. P. Kale",
      schedule: "Thursday, 5:30 PM",
      venue: "Open Air Theatre",
      members: "160+ active members",
      contact: "culturalclub@sanjivani.edu",
      upcoming: "Annual Cultural Showcase - 18 April 2026",
      focusAreas: ["Music and dance teams", "Drama and stage craft", "Event production and anchoring"],
      achievements: ["Won zonal youth festival 2025", "Organized 30+ stage performances", "Collaborated with 8 colleges"]
    }
  };

  const [selectedEvent, setSelectedEvent] = useState(null);
  const [defaultEvent, setDefaultEvent] = useState("");

  const handleRegister = (event) => {
    setDefaultEvent(event.name);

    document.getElementById("register").scrollIntoView({ behavior: "smooth" });
  };

  const handleSubmit = (e, submittedFormData) => {
    e.preventDefault();
    alert("Registration successful for " + submittedFormData.event);
  };

  return (
    <div className="app-shell">
      <Navbar />
      <main className="page-content">
        <div className="hero">
          <p className="hero-kicker">Sanjivani Campus Network</p>
          <h1>College Event Management</h1>
          <p>Explore events, workshops and club activities</p>
        </div>
        <section id="events" className="section-block">
          <h2 className="section-title">Upcoming Events</h2>
          <div className="event-grid">
            {events.map((event) => (
              <EventCard
                key={event.name}
                event={event}
                onView={setSelectedEvent}
                onRegister={handleRegister}
              />
            ))}
          </div>
        </section>
        {selectedEvent && (
          <section className="section-block">
            <EventDetails event={selectedEvent} onRegister={handleRegister} />
          </section>
        )}
        <section id="clubs" className="section-block">
          <Clubs clubs={clubs} />
        </section>
        <section id="register" className="section-block">
          <RegisterForm
            handleSubmit={handleSubmit}
            defaultEvent={defaultEvent}
            events={events}
          />
        </section>
      </main>
    </div>
  );
}

export default App;
