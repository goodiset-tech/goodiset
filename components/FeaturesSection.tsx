import { Truck, Shield, HeartHandshake, Award } from "lucide-react";

const features = [
  {
    icon: Truck,
    title: "Fast Delivery",
    description: "Free shipping on orders over AED 100. Same-day delivery available in Dubai.",
  },
  {
    icon: Shield,
    title: "Quality Guaranteed",
    description: "All products are sourced directly from Sweden and stored in optimal conditions.",
  },
  {
    icon: HeartHandshake,
    title: "Halal Certified",
    description: "Many of our candies are halal-certified for your peace of mind.",
  },
  {
    icon: Award,
    title: "Premium Selection",
    description: "Curated collection of the finest Scandinavian sweets and chocolates.",
  },
];

export default function FeaturesSection() {
  return (
    <section className="py-16 lg:py-24 bg-gray-50">
      <div className="container">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          {features.map((feature, index) => (
            <div
              key={index}
              className="text-center p-6 bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow"
            >
              <div className="inline-flex items-center justify-center w-14 h-14 bg-[#e63946]/10 text-[#e63946] rounded-full mb-4">
                <feature.icon className="w-7 h-7" />
              </div>
              <h3 className="text-lg font-semibold text-gray-900 mb-2">
                {feature.title}
              </h3>
              <p className="text-gray-600 text-sm leading-relaxed">
                {feature.description}
              </p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
