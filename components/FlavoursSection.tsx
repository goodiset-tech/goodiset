import Link from "next/link";

const flavours = [
  { name: "Sour", color: "#4ADE80", slug: "sour" },
  { name: "Sweet", color: "#F472B6", slug: "sweet" },
  { name: "Fruity", color: "#FB923C", slug: "fruity" },
  { name: "Chocolate", color: "#92400E", slug: "chocolate" },
  { name: "Licorice", color: "#1F2937", slug: "licorice" },
  { name: "Salty", color: "#60A5FA", slug: "salty" },
  { name: "Fizzy", color: "#FACC15", slug: "fizzy" },
  { name: "Creamy", color: "#FEF3C7", slug: "creamy" },
];

export default function FlavoursSection() {
  return (
    <section className="py-16 lg:py-24 bg-white">
      <div className="container">
        <div className="flex flex-col lg:flex-row items-center gap-12">
          {/* Text */}
          <div className="lg:w-1/3">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              Explore by <span className="text-[#e63946]">Flavour</span>
            </h2>
            <p className="text-gray-600">
              Find your perfect match! Browse our collection by flavour profile and 
              discover new favorites from our Swedish candy selection.
            </p>
          </div>

          {/* Flavour Buttons */}
          <div className="lg:w-2/3">
            <div className="flex flex-wrap gap-3 justify-center lg:justify-start">
              {flavours.map((flavour) => (
                <Link
                  key={flavour.slug}
                  href={`/shop?flavour=${flavour.slug}`}
                  className="group relative px-6 py-3 rounded-full font-medium transition-all duration-300 hover:scale-105 hover:shadow-lg"
                  style={{
                    backgroundColor: `${flavour.color}20`,
                    color: flavour.color === "#FEF3C7" ? "#92400E" : flavour.color,
                  }}
                >
                  <span
                    className="absolute inset-0 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"
                    style={{ backgroundColor: `${flavour.color}40` }}
                  />
                  <span className="relative">{flavour.name}</span>
                </Link>
              ))}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
