"use client";

export default function FeaturesSection() {
  return (
    <section className="features">
      <div className="container">
        <div className="row feature-cards n_m_t">
          {/* Fast Delivery */}
          <div className="col-lg-4 col-md-6 col-12">
            <div className="feature-card">
              <div className="feature-icon">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M4 32H12M12 32V44H40V32M12 32V20H32L40 32M40 32H52L56 44H40M16 52C16 54.2091 14.2091 56 12 56C9.79086 56 8 54.2091 8 52C8 49.7909 9.79086 48 12 48C14.2091 48 16 49.7909 16 52ZM52 52C52 54.2091 50.2091 56 48 56C45.7909 56 44 54.2091 44 52C44 49.7909 45.7909 48 48 48C50.2091 48 52 49.7909 52 52Z" stroke="#e92827" strokeWidth="4" strokeLinecap="round" strokeLinejoin="round"/>
                </svg>
              </div>
              <h3>Fast Delivery</h3>
              <p>Free shipping on orders over AED 100. Same-day delivery available in Dubai.</p>
            </div>
          </div>

          {/* Quality Guaranteed */}
          <div className="col-lg-4 col-md-6 col-12">
            <div className="feature-card">
              <div className="feature-icon">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M32 4L8 16V32C8 46.4 18.4 59.2 32 62C45.6 59.2 56 46.4 56 32V16L32 4Z" stroke="#e92827" strokeWidth="4" strokeLinecap="round" strokeLinejoin="round"/>
                  <path d="M24 32L28 36L40 24" stroke="#e92827" strokeWidth="4" strokeLinecap="round" strokeLinejoin="round"/>
                </svg>
              </div>
              <h3>Quality Guaranteed</h3>
              <p>All products are sourced directly from Sweden and stored in optimal conditions.</p>
            </div>
          </div>

          {/* Premium Selection */}
          <div className="col-lg-4 col-md-6 col-12">
            <div className="feature-card">
              <div className="feature-icon">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M32 4L38.18 22.82L58 22.82L41.82 34.36L48 53.18L32 41.64L16 53.18L22.18 34.36L6 22.82L25.82 22.82L32 4Z" stroke="#e92827" strokeWidth="4" strokeLinecap="round" strokeLinejoin="round"/>
                </svg>
              </div>
              <h3>Premium Selection</h3>
              <p>Curated collection of the finest Scandinavian sweets and chocolates.</p>
            </div>
          </div>
        </div>
      </div>

      <style jsx>{`
        .features {
          background-color: #fff5f5;
          width: 100%;
          padding: 40px 0;
        }
        .container {
          max-width: 1290px;
          margin: 0 auto;
          padding: 0 15px;
        }
        .feature-cards {
          display: flex;
          justify-content: center;
          gap: 30px;
          flex-wrap: wrap;
        }
        .feature-card {
          background: #fff;
          border-radius: 16px;
          padding: 32px 24px;
          text-align: center;
          box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
          max-width: 300px;
          flex: 1;
          min-width: 280px;
        }
        .feature-icon {
          margin-bottom: 16px;
        }
        .feature-icon svg {
          width: 64px;
          height: 64px;
        }
        .feature-card h3 {
          font-family: "DM Sans", sans-serif;
          font-size: 18px;
          font-weight: 700;
          margin-bottom: 8px;
          color: #303030;
        }
        .feature-card p {
          font-size: 14px;
          color: #6e6e6e;
          line-height: 1.5;
          margin: 0;
        }
        @media (max-width: 768px) {
          .feature-cards {
            flex-direction: column;
            align-items: center;
          }
          .feature-card {
            max-width: 100%;
            width: 100%;
          }
        }
      `}</style>
    </section>
  );
}
